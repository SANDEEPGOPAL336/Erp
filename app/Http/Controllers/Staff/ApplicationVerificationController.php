<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use App\Models\AdmissionApplication;
use App\Models\Semester;
use App\Models\StaffProfile;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class ApplicationVerificationController extends Controller
{
    /**
     * List submitted applications that match any active academic assignment
     * for the currently authenticated staff profile.
     */
    public function index(Request $request)
    {
        $user = $request->user();
        abort_unless($user && $user->role === 'staff', 403, 'Unauthorized access.');

        $staffProfile = StaffProfile::query()
            ->where('user_id', $user->id)
            ->where('is_active', true)
            ->first();

        abort_unless($staffProfile, 403, 'Active staff profile not found.');

        // Load every active assignment. A teacher may have multiple courses,
        // departments, sessions, and optional semester-specific assignments.
        $assignments = $staffProfile->assignments()
            ->with(['course', 'session', 'semester'])
            ->where('is_active', true)
            ->get();

        $courseOptions = $assignments
            ->pluck('course')
            ->filter()
            ->unique('id')
            ->sortBy('name')
            ->values();

        $courseIds = $assignments->pluck('course_id')->filter()->unique()->values();

        $sessionOptions = $assignments
            ->pluck('session')
            ->filter()
            ->unique('id')
            ->sortByDesc('start_date')
            ->values();

        $semesterOptions = $assignments->contains(fn ($assignment) => $assignment->semester_id === null)
            ? Semester::query()->where('is_active', true)->orderBy('semester_number')->get()
            : $assignments->pluck('semester')
                ->filter()
                ->unique('id')
                ->sortBy('semester_number')
                ->values();

        $applicationsQuery = AdmissionApplication::query()
            ->with([
                'student.studentProfile',
                'course',
                'session',
                'semester',
            ])
            ->where('status', 'submitted');

        if ($assignments->isEmpty()) {
            $applicationsQuery->whereRaw('1 = 0');
        } else {
            // Match each course AND session pair together. Using separate
            // whereIn() lists could accidentally combine unrelated pairs.
            $applicationsQuery->where(function (Builder $assignmentQuery) use ($assignments) {
                foreach ($assignments as $assignment) {
                    $assignmentQuery->orWhere(function (Builder $pairQuery) use ($assignment) {
                        $pairQuery
                            ->where('course_id', $assignment->course_id)
                            ->where('academic_session_id', $assignment->academic_session_id);

                        // A null assignment semester means all semesters.
                        // A course-only application (semester_id NULL) is also
                        // allowed, matching the current application workflow.
                        if ($assignment->semester_id !== null) {
                            $pairQuery->where(function (Builder $semesterQuery) use ($assignment) {
                                $semesterQuery
                                    ->whereNull('semester_id')
                                    ->orWhere('semester_id', $assignment->semester_id);
                            });
                        }
                    });
                }
            });
        }

        $selectedCourse = '';
        if ($request->filled('course_id')) {
            $requestedCourse = (int) $request->input('course_id');
            if ($courseIds->contains($requestedCourse)) {
                $selectedCourse = $requestedCourse;
                $applicationsQuery->where('course_id', $requestedCourse);
            }
        }

        $semesterIds = $semesterOptions->pluck('id');
        $selectedSemester = '';
        if ($request->filled('semester_id')) {
            $requestedSemester = (int) $request->input('semester_id');
            if ($semesterIds->contains($requestedSemester)) {
                $selectedSemester = $requestedSemester;
                $applicationsQuery->where('semester_id', $requestedSemester);
            }
        }

        $applications = $applicationsQuery
            ->orderByDesc('submitted_at')
            ->orderByDesc('id')
            ->paginate(20)
            ->withQueryString();

        return view('staff.applications.index', [
            'applications' => $applications,
            'staffProfile' => $staffProfile,
            'assignments' => $assignments,
            // These aliases are both supplied because the current Blade view
            // accepts either naming convention.
            'courses' => $courseOptions,
            'courseOptions' => $courseOptions,
            'semesters' => $semesterOptions,
            'semesterOptions' => $semesterOptions,
            'sessionOptions' => $sessionOptions,
            'selectedCourse' => $selectedCourse,
            'selectedSemester' => $selectedSemester,
        ]);
    }

    /** View a complete application only when it is assigned to this teacher. */
    public function show(Request $request, $id)
    {
        $application = $this->getAssignedApplication(
            $request,
            $id,
            ['submitted', 'approved', 'rejected']
        );

        if (!$application) {
            abort(404, 'Application not found or not assigned to you.');
        }

        $application->load([
            'student.studentProfile.qualifications',
            'student.studentProfile.documents',
            'course',
            'session',
            'semester',
        ]);

        return view('staff.applications.show', compact('application'));
    }

    /** Approve an assigned submitted application. */
    public function approve(Request $request, $id)
    {
        $application = $this->getAssignedApplication($request, $id, ['submitted']);

        if (!$application) {
            abort(404, 'Application not found or not assigned to you.');
        }

        $data = $request->validate([
            'remarks' => ['nullable', 'string', 'max:1000'],
        ]);

        $application->status = 'approved';
        $application->reviewed_by = $request->user()->id;
        $application->review_remarks = $data['remarks'] ?? null;
        $application->reviewed_at = now();
        $application->save();

        return redirect()
            ->route('staff.applications.show', $application->id)
            ->with('success', 'Application approved successfully. All student application fields are now locked.');
    }

    /** Reject an assigned submitted application with a mandatory reason. */
    public function reject(Request $request, $id)
    {
        $application = $this->getAssignedApplication($request, $id, ['submitted']);

        if (!$application) {
            abort(404, 'Application not found or not assigned to you.');
        }

        $data = $request->validate([
            'remarks' => ['required', 'string', 'max:1000'],
        ], [
            'remarks.required' => 'Please enter the reason for rejection.',
        ]);

        $application->status = 'rejected';
        $application->reviewed_by = $request->user()->id;
        $application->review_remarks = $data['remarks'];
        $application->reviewed_at = now();
        $application->save();

        return redirect()
            ->route('staff.applications.show', $application->id)
            ->with('success', 'Application rejected successfully. The student can now edit and resubmit the application.');
    }

    /**
     * Return the requested application only if an active assignment matches
     * its course, academic session, and (when specified) semester.
     */
    private function getAssignedApplication(Request $request, $id, array $allowedStatuses = [])
    {
        $user = $request->user();
        if (!$user || $user->role !== 'staff') {
            return null;
        }

        $staffProfile = StaffProfile::query()
            ->where('user_id', $user->id)
            ->where('is_active', true)
            ->first();

        if (!$staffProfile) {
            return null;
        }

        $assignments = $staffProfile->assignments()
            ->where('is_active', true)
            ->get();

        if ($assignments->isEmpty()) {
            return null;
        }

        $applicationQuery = AdmissionApplication::query()
            ->with(['student.studentProfile', 'course', 'session', 'semester'])
            ->whereKey($id);

        if ($allowedStatuses !== []) {
            $applicationQuery->whereIn('status', $allowedStatuses);
        }

        $application = $applicationQuery->first();
        if (!$application) {
            return null;
        }

        $hasAssignment = $assignments->contains(function ($assignment) use ($application) {
            if ((int) $assignment->course_id !== (int) $application->course_id) {
                return false;
            }

            if ((int) $assignment->academic_session_id !== (int) $application->academic_session_id) {
                return false;
            }

            // Null semester assignment means all semesters. Preserve the
            // course-only application behavior when application semester is NULL.
            if ($assignment->semester_id !== null && $application->semester_id !== null) {
                if ((int) $assignment->semester_id !== (int) $application->semester_id) {
                    return false;
                }
            }

            return true;
        });

        return $hasAssignment ? $application : null;
    }
}
