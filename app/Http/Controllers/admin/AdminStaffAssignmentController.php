<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\StaffAssignment;
use App\Models\StaffProfile;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class AdminStaffAssignmentController extends Controller
{
    private function ensureAdmin(Request $request): void
    {
        abort_unless($request->user() && $request->user()->role === 'admin', 403);
    }

    public function index(Request $request)
    {
        $this->ensureAdmin($request);

        $staffProfiles = StaffProfile::query()
            ->with('user')
            ->whereHas('user', function ($query) {
                $query->where('role', 'staff');
            })
            ->orderBy('employee_code')
            ->get();

        $departments = DB::table('departments')
            ->where('is_active', true)
            ->orderBy('name')
            ->get(['id', 'name']);

        $subDepartments = DB::table('sub_departments')
            ->where('is_active', true)
            ->orderBy('name')
            ->get(['id', 'department_id', 'name']);

        $courses = DB::table('courses')
            ->where('is_active', true)
            ->orderBy('name')
            ->get(['id', 'sub_department_id', 'code', 'name']);

        $sessions = DB::table('academic_sessions')
            ->where('is_active', true)
            ->orderByDesc('start_date')
            ->get(['id', 'name', 'start_date', 'end_date']);

        $semesters = DB::table('semesters')
            ->where('is_active', true)
            ->orderBy('semester_number')
            ->get(['id', 'name', 'semester_number']);

        $departmentNames = DB::table('departments')->pluck('name', 'id');
        $subDepartmentNames = DB::table('sub_departments')->pluck('name', 'id');
        $subDepartmentDepartmentIds = DB::table('sub_departments')->pluck('department_id', 'id');

        $assignments = StaffAssignment::query()
            ->with(['staffProfile.user', 'course', 'session', 'semester'])
            ->orderByDesc('id')
            ->paginate(25)
            ->withQueryString();

        return view('admin.staff-assignments.index', compact(
            'staffProfiles',
            'departments',
            'subDepartments',
            'courses',
            'sessions',
            'semesters',
            'departmentNames',
            'subDepartmentNames',
            'subDepartmentDepartmentIds',
            'assignments'
        ));
    }

    public function store(Request $request)
    {
        $this->ensureAdmin($request);

        $data = $request->validate([
            'staff_profile_id' => ['required', 'integer', Rule::exists('staff_profiles', 'id')],
            'department_id' => ['required', 'integer', Rule::exists('departments', 'id')],
            'sub_department_id' => ['required', 'integer', Rule::exists('sub_departments', 'id')],
            'course_id' => ['required', 'integer', Rule::exists('courses', 'id')],
            'academic_session_id' => ['required', 'integer', Rule::exists('academic_sessions', 'id')],
            'semester_id' => ['nullable', 'integer', Rule::exists('semesters', 'id')],
        ]);

        $staffProfile = StaffProfile::query()
            ->with('user')
            ->findOrFail($data['staff_profile_id']);

        if (!$staffProfile->user || $staffProfile->user->role !== 'staff') {
            return back()->withInput()->withErrors([
                'staff_profile_id' => 'Choose a valid staff member, not an administrator or student.',
            ]);
        }

        $subDepartmentMatches = DB::table('sub_departments')
            ->where('id', $data['sub_department_id'])
            ->where('department_id', $data['department_id'])
            ->where('is_active', true)
            ->exists();

        if (!$subDepartmentMatches) {
            return back()->withInput()->withErrors([
                'sub_department_id' => 'The selected sub-department does not belong to the selected department.',
            ]);
        }

        $courseMatches = DB::table('courses')
            ->where('id', $data['course_id'])
            ->where('sub_department_id', $data['sub_department_id'])
            ->where('is_active', true)
            ->exists();

        if (!$courseMatches) {
            return back()->withInput()->withErrors([
                'course_id' => 'Choose a course that belongs to the selected sub-department.',
            ]);
        }

        $sessionIsActive = DB::table('academic_sessions')
            ->where('id', $data['academic_session_id'])
            ->where('is_active', true)
            ->exists();

        if (!$sessionIsActive) {
            return back()->withInput()->withErrors([
                'academic_session_id' => 'Choose an active academic session.',
            ]);
        }

        $semesterId = $data['semester_id'] ?? null;

        try {
            DB::transaction(function () use ($staffProfile, $data, $semesterId) {
                // Keep the staff member's primary department profile in sync.
                $staffProfile->department_id = $data['department_id'];
                $staffProfile->sub_department_id = $data['sub_department_id'];
                $staffProfile->save();

                $assignmentQuery = StaffAssignment::query()
                    ->where('staff_profile_id', $staffProfile->id)
                    ->where('academic_session_id', $data['academic_session_id'])
                    ->where('course_id', $data['course_id']);

                if ($semesterId === null) {
                    $assignmentQuery->whereNull('semester_id');
                } else {
                    $assignmentQuery->where('semester_id', $semesterId);
                }

                $assignment = $assignmentQuery->first();

                $assignmentData = [
                    'staff_profile_id' => $staffProfile->id,
                    'academic_session_id' => $data['academic_session_id'],
                    'course_id' => $data['course_id'],
                    'semester_id' => $semesterId,
                    'role_type' => 'unit_teacher',
                    'is_active' => true,
                ];

                if ($assignment) {
                    $assignment->update([
                        'role_type' => 'unit_teacher',
                        'is_active' => true,
                    ]);
                } else {
                    StaffAssignment::query()->create($assignmentData);
                }
            });
        } catch (QueryException $exception) {
            report($exception);

            return back()->withInput()->withErrors([
                'assignment' => 'The assignment could not be saved. Check that the staff assignment table and its relationships are up to date.',
            ]);
        }

        return redirect()
            ->route('admin.staff.departments')
            ->with('success', 'Department and course assignment saved. The staff member can now see matching applications if the New Applicants permission is enabled.');
    }

    public function destroy(Request $request, StaffAssignment $assignment)
    {
        $this->ensureAdmin($request);

        // Preserve the record for audit purposes; it will no longer grant access.
        $assignment->update(['is_active' => false]);

        return redirect()
            ->route('admin.staff.assignments')
            ->with('success', 'Assignment deactivated successfully.');
    }
}
