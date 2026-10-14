<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\AdmissionApplication;
use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class AdmissionController extends Controller
{
    /**
     * Step 1: Course / Programme Selection
     */
    public function courseForm(Request $request)
    {
        $application = AdmissionApplication::where(
            'user_id',
            $request->user()->id
        )
        ->latest()
        ->firstOrFail();

        /*
        |--------------------------------------------------------------------------
        | Active Departments
        |--------------------------------------------------------------------------
        */
        $departments = DB::table('departments')
            ->where('is_active', true)
            ->orderBy('name')
            ->get();

        /*
        |--------------------------------------------------------------------------
        | Active Courses
        |--------------------------------------------------------------------------
        |
        | We load the courses along with their department_id.
        | JavaScript in the Blade file will filter them according
        | to the selected department.
        |
        */
        $courses = Course::where('is_active', true)
            ->orderBy('name')
            ->get();

        /*
        |--------------------------------------------------------------------------
        | Current Department
        |--------------------------------------------------------------------------
        |
        | Department is derived from the currently selected course.
        | We do NOT store department_id in admission_applications.
        |
        */
        $selectedDepartmentId = null;

        if ($application->course_id) {

            $selectedCourse = Course::find($application->course_id);

            if ($selectedCourse) {
                $selectedDepartmentId = $selectedCourse->department_id;
            }
        }

        return view(
            'student.admission.course',
            compact(
                'application',
                'departments',
                'courses',
                'selectedDepartmentId'
            )
        );
    }

    /**
     * Save Department + Course Selection
     */
    public function saveCourse(Request $request)
    {
        $data = $request->validate([
            'department_id' => [
                'required',
                'exists:departments,id'
            ],

            'course_id' => [
                'required',
                'exists:courses,id'
            ],
        ]);

        /*
        |--------------------------------------------------------------------------
        | Verify Department Is Active
        |--------------------------------------------------------------------------
        */
        $department = DB::table('departments')
            ->where('id', $data['department_id'])
            ->where('is_active', true)
            ->first();

        if (!$department) {

            throw ValidationException::withMessages([
                'department_id' => 'The selected department is not active.'
            ]);
        }

        /*
        |--------------------------------------------------------------------------
        | Verify Course
        |--------------------------------------------------------------------------
        |
        | The selected course must:
        | 1. Exist
        | 2. Be active
        | 3. Belong to the selected department
        |
        */
        $course = Course::where(
            'id',
            $data['course_id']
        )
        ->where(
            'is_active',
            true
        )
        ->where(
            'department_id',
            $data['department_id']
        )
        ->first();

        if (!$course) {

            throw ValidationException::withMessages([
                'course_id' =>
                    'The selected course does not belong to the selected department.'
            ]);
        }

        /*
        |--------------------------------------------------------------------------
        | Get Current Application
        |--------------------------------------------------------------------------
        */
        $application = AdmissionApplication::where(
            'user_id',
            $request->user()->id
        )
        ->latest()
        ->firstOrFail();

        /*
        |--------------------------------------------------------------------------
        | Save Course
        |--------------------------------------------------------------------------
        |
        | Department is intentionally not stored in admission_applications.
        | It is derived from courses.department_id.
        |
        */
        $application->update([
            'course_id' => $course->id,
        ]);

        return redirect()
            ->route('student.personal')
            ->with(
                'success',
                'Department and course selected successfully.'
            );
    }
}