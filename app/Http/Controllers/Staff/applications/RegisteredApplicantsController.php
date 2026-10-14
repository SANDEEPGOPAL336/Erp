<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use App\Models\AdmissionApplication;
use App\Models\Semester;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class RegisteredApplicantsController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();
        abort_unless($user && $user->role === 'staff', 403);

        $staffProfile = $user->staffProfile;
        abort_unless($staffProfile && $staffProfile->is_active, 403);

        $assignments = $staffProfile->assignments()
            ->with(['course', 'session', 'semester'])
            ->where('is_active', true)
            ->get();

        $courseIds = $assignments->pluck('course_id')->filter()->unique()->values();
        $sessionIds = $assignments->pluck('academic_session_id')->filter()->unique()->values();

        $courseOptions = $assignments->pluck('course')
            ->filter()->unique('id')->sortBy('name')->values();

        $sessionOptions = $assignments->pluck('session')
            ->filter()->unique('id')->sortByDesc('start_date')->values();

        if ($assignments->contains(fn ($assignment) => $assignment->semester_id === null)) {
            $semesterOptions = Semester::query()
                ->where('is_active', true)
                ->orderBy('semester_number')
                ->get();
        } else {
            $semesterOptions = $assignments->pluck('semester')
                ->filter()->unique('id')->sortBy('semester_number')->values();
        }

        // Registered means teacher-approved and awaiting first-fee verification.
        // Final active enrollments are excluded from this page.
        $query = $this->accessibleApplicationsQuery($assignments);

        $selectedSession = $request->filled('session_id') ? (int) $request->session_id : null;
        $selectedCourse = $request->filled('course_id') ? (int) $request->course_id : null;
        $selectedYear = $request->filled('year_number') ? (int) $request->year_number : null;
        $selectedSemester = $request->filled('semester_id') ? (int) $request->semester_id : null;
        $search = trim((string) $request->input('search', ''));

        if ($selectedSession && !$sessionIds->contains($selectedSession)) {
            $selectedSession = null;
        }
        if ($selectedCourse && !$courseIds->contains($selectedCourse)) {
            $selectedCourse = null;
        }
        if ($selectedSemester && !$semesterOptions->pluck('id')->contains($selectedSemester)) {
            $selectedSemester = null;
        }

        if ($selectedSession) {
            $query->where('academic_session_id', $selectedSession);
        }
        if ($selectedCourse) {
            $query->where('course_id', $selectedCourse);
        }
        if ($selectedSemester) {
            $query->where('semester_id', $selectedSemester);
        }
        if ($selectedYear) {
            $query->whereHas('semester', function (Builder $q) use ($selectedYear) {
                $q->whereRaw('CEIL(semester_number / 2) = ?', [$selectedYear]);
            });
        }

        if ($search !== '') {
            $query->where(function (Builder $q) use ($search) {
                $q->where('application_no', 'like', '%' . $search . '%')
                    ->orWhereHas('student', function (Builder $studentQuery) use ($search) {
                        $studentQuery->where('name', 'like', '%' . $search . '%')
                            ->orWhere('email', 'like', '%' . $search . '%')
                            ->orWhere('phone', 'like', '%' . $search . '%');
                    })
                    ->orWhereHas('course', function (Builder $courseQuery) use ($search) {
                        $courseQuery->where('name', 'like', '%' . $search . '%')
                            ->orWhere('code', 'like', '%' . $search . '%');
                    });
            });
        }

        $totalRegistered = (clone $query)->count();
        $yearCounts = [];

        foreach ([1, 2, 3, 4] as $year) {
            $yearCounts[$year] = (clone $query)
                ->whereHas('semester', function (Builder $q) use ($year) {
                    $q->whereRaw('CEIL(semester_number / 2) = ?', [$year]);
                })
                ->count();
        }

        $registeredApplicants = $query
            ->with(['student.studentProfile', 'course', 'session', 'semester'])
            ->orderByDesc('reviewed_at')
            ->orderByDesc('id')
            ->paginate(20)
            ->withQueryString();

        return view('staff.registered-applicants.index', [
            'staffProfile' => $staffProfile,
            'assignments' => $assignments,
            'registeredApplicants' => $registeredApplicants,
            // Keep this alias temporarily if your current Blade still uses it.
            'registeredStudents' => $registeredApplicants,
            'courseOptions' => $courseOptions,
            'sessionOptions' => $sessionOptions,
            'semesterOptions' => $semesterOptions,
            'totalRegistered' => $totalRegistered,
            'yearCounts' => $yearCounts,
            'selectedSession' => $selectedSession,
            'selectedCourse' => $selectedCourse,
            'selectedYear' => $selectedYear,
            'selectedSemester' => $selectedSemester,
            'search' => $search,
        ]);
    }

    private function accessibleApplicationsQuery($assignments): Builder
    {
        $query = AdmissionApplication::query()
            ->where('status', 'approved')
            ->whereNotExists(function ($subQuery) {
                $subQuery->selectRaw('1')
                    ->from('student_enrollments')
                    ->whereColumn(
                        'student_enrollments.admission_application_id',
                        'admission_applications.id'
                    )
                    ->where('student_enrollments.enrollment_status', 'active');
            })
            ->whereNotExists(function ($subQuery) {
                $subQuery->selectRaw('1')
                    ->from('student_fee_payments')
                    ->whereColumn(
                        'student_fee_payments.admission_application_id',
                        'admission_applications.id'
                    )
                    ->where('student_fee_payments.installment_number', 1)
                    ->where('student_fee_payments.status', 'verified');
            });

        if ($assignments->isEmpty()) {
            return $query->whereRaw('1 = 0');
        }

        $query->where(function (Builder $scope) use ($assignments) {
            foreach ($assignments as $assignment) {
                $scope->orWhere(function (Builder $assignmentQuery) use ($assignment) {
                    $assignmentQuery
                        ->where('course_id', $assignment->course_id)
                        ->where('academic_session_id', $assignment->academic_session_id);

                    // A NULL semester is allowed for older applications that predate
                    // the semester selector. New applications should save a semester.
                    if ($assignment->semester_id !== null) {
                        $assignmentQuery->where(function (Builder $semesterQuery) use ($assignment) {
                            $semesterQuery
                                ->whereNull('semester_id')
                                ->orWhere('semester_id', $assignment->semester_id);
                        });
                    }
                });
            }
        });

        return $query;
    }
}
