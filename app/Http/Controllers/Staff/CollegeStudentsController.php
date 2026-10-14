<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use App\Models\Semester;
use App\Models\StaffProfile;
use App\Models\StudentEnrollment;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class CollegeStudentsController extends Controller
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

        $courseOptions = $assignments->pluck('course')->filter()->unique('id')->sortBy('name')->values();
        $sessionOptions = $assignments->pluck('session')->filter()->unique('id')->sortByDesc('start_date')->values();
        $semesterOptions = $assignments->contains(fn ($a) => is_null($a->semester_id))
            ? Semester::query()->where('is_active', true)->orderBy('semester_number')->get()
            : $assignments->pluck('semester')->filter()->unique('id')->sortBy('semester_number')->values();

        $query = $this->accessibleEnrollmentQuery($assignments);

        $selectedSession = $request->filled('session_id') ? (int) $request->session_id : null;
        $selectedCourse = $request->filled('course_id') ? (int) $request->course_id : null;
        $selectedYear = $request->filled('year_number') ? (int) $request->year_number : null;
        $selectedSemester = $request->filled('semester_id') ? (int) $request->semester_id : null;
        $search = trim((string) $request->input('search', ''));

        if ($selectedSession) $query->where('academic_session_id', $selectedSession);
        if ($selectedCourse) $query->where('course_id', $selectedCourse);
        if ($selectedYear) $query->where('year_number', $selectedYear);
        if ($selectedSemester) $query->where('current_semester_id', $selectedSemester);

        if ($search !== '') {
            $query->where(function (Builder $q) use ($search) {
                $q->where('college_number', 'like', '%' . $search . '%')
                    ->orWhere('roll_number', 'like', '%' . $search . '%')
                    ->orWhereHas('student', function (Builder $studentQuery) use ($search) {
                        $studentQuery->where('name', 'like', '%' . $search . '%')
                            ->orWhere('phone', 'like', '%' . $search . '%')
                            ->orWhere('email', 'like', '%' . $search . '%');
                    });
            });
        }

        $totalStudents = (clone $query)->count();
        $yearCounts = [];
        foreach ([1, 2, 3, 4] as $year) {
            $yearCounts[$year] = (clone $query)->where('year_number', $year)->count();
        }

        $students = $query
            ->orderBy('course_id')
            ->orderBy('year_number')
            ->orderBy('roll_number')
            ->paginate(25)
            ->withQueryString();

        return view('staff.college-students.index', [
            'staffProfile' => $staffProfile,
            'assignments' => $assignments,
            'students' => $students,
            'courseOptions' => $courseOptions,
            'sessionOptions' => $sessionOptions,
            'semesterOptions' => $semesterOptions,
            'totalStudents' => $totalStudents,
            'yearCounts' => $yearCounts,
            'selectedSession' => $selectedSession,
            'selectedCourse' => $selectedCourse,
            'selectedYear' => $selectedYear,
            'selectedSemester' => $selectedSemester,
            'search' => $search,
        ]);
    }

    private function accessibleEnrollmentQuery($assignments): Builder
    {
        $query = StudentEnrollment::query()
            ->with([
                'student.studentProfile',
                'course',
                'academicSession',
                'currentSemester',
                'admissionApplication',
            ])
            ->where('enrollment_status', 'active');

        if ($assignments->isEmpty()) {
            return $query->whereRaw('1 = 0');
        }

        $query->where(function (Builder $scope) use ($assignments) {
            foreach ($assignments as $assignment) {
                $scope->orWhere(function (Builder $assignmentQuery) use ($assignment) {
                    $assignmentQuery
                        ->where('course_id', $assignment->course_id)
                        ->where('academic_session_id', $assignment->academic_session_id);

                    if ($assignment->semester_id) {
                        $assignmentQuery->where('current_semester_id', $assignment->semester_id);
                    }
                });
            }
        });

        return $query;
    }
}
