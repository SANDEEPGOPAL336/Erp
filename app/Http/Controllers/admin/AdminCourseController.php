<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class AdminCourseController extends Controller
{
    /**
     * Display all courses.
     */
    public function index()
    {
        $courses = Course::with('department')
            ->orderBy('name')
            ->get();

        return view(
            'admin.courses.index',
            compact('courses')
        );
    }


    /**
     * Show create course form.
     */
    public function create()
    {
        $departments = DB::table('departments')
            ->where('is_active', true)
            ->orderBy('name')
            ->get();

        return view(
            'admin.courses.create',
            compact('departments')
        );
    }


    /**
     * Store new course.
     */
    public function store(Request $request)
    {
        $data = $request->validate([

            'department_id' => [
                'required',
                'exists:departments,id',
            ],

            'name' => [
                'required',
                'string',
                'max:255',
            ],

            'code' => [
                'required',
                'string',
                'max:255',
                'unique:courses,code',
            ],

            'duration' => [
                'nullable',
                'string',
                'max:255',
            ],

            'admission_fee' => [
                'required',
                'numeric',
                'min:0',
            ],

            'annual_fee' => [
                'required',
                'numeric',
                'min:0',
            ],

        ]);


        /*
        |--------------------------------------------------------------------------
        | Make sure Department is active
        |--------------------------------------------------------------------------
        */

        $department = DB::table('departments')
            ->where('id', $data['department_id'])
            ->where('is_active', true)
            ->first();

        if (!$department) {

            return back()
                ->withInput()
                ->withErrors([
                    'department_id' =>
                        'The selected department is not active.'
                ]);
        }


        /*
        |--------------------------------------------------------------------------
        | Create Course
        |--------------------------------------------------------------------------
        */

        Course::create([

            'department_id' => $data['department_id'],

            'name' => $data['name'],

            'code' => strtoupper($data['code']),

            'duration' => $data['duration'] ?? null,

            'admission_fee' => $data['admission_fee'],

            'annual_fee' => $data['annual_fee'],

            'is_active' => true,

        ]);


        return redirect()
            ->route('admin.courses.index')
            ->with(
                'success',
                'Course / Programme added successfully.'
            );
    }


    /**
     * Show edit course form.
     */
    public function edit(Course $course)
    {
        $departments = DB::table('departments')
            ->where('is_active', true)
            ->orderBy('name')
            ->get();

        /*
        |--------------------------------------------------------------------------
        | If the course currently belongs to an inactive department,
        | include that department so the existing value is still visible.
        |--------------------------------------------------------------------------
        */

        if (
            $course->department_id &&
            !$departments->contains(
                'id',
                $course->department_id
            )
        ) {

            $currentDepartment = DB::table('departments')
                ->where('id', $course->department_id)
                ->first();

            if ($currentDepartment) {

                $departments->push(
                    $currentDepartment
                );

                $departments = $departments
                    ->sortBy('name')
                    ->values();
            }
        }


        return view(
            'admin.courses.edit',
            compact(
                'course',
                'departments'
            )
        );
    }


    /**
     * Update existing course.
     */
    public function update(
        Request $request,
        Course $course
    ) {

        $data = $request->validate([

            'department_id' => [
                'required',
                'exists:departments,id',
            ],

            'name' => [
                'required',
                'string',
                'max:255',
            ],

            'code' => [
                'required',
                'string',
                'max:255',
                Rule::unique(
                    'courses',
                    'code'
                )->ignore($course->id),
            ],

            'duration' => [
                'nullable',
                'string',
                'max:255',
            ],

            'admission_fee' => [
                'required',
                'numeric',
                'min:0',
            ],

            'annual_fee' => [
                'required',
                'numeric',
                'min:0',
            ],

        ]);


        /*
        |--------------------------------------------------------------------------
        | Make sure Department is active
        |--------------------------------------------------------------------------
        */

        $department = DB::table('departments')
            ->where('id', $data['department_id'])
            ->where('is_active', true)
            ->first();

        if (!$department) {

            return back()
                ->withInput()
                ->withErrors([
                    'department_id' =>
                        'The selected department is not active.'
                ]);
        }


        /*
        |--------------------------------------------------------------------------
        | Update Course
        |--------------------------------------------------------------------------
        */

        $course->update([

            'department_id' => $data['department_id'],

            'name' => $data['name'],

            'code' => strtoupper($data['code']),

            'duration' => $data['duration'] ?? null,

            'admission_fee' => $data['admission_fee'],

            'annual_fee' => $data['annual_fee'],

        ]);


        return redirect()
            ->route('admin.courses.index')
            ->with(
                'success',
                'Course / Programme updated successfully.'
            );
    }


    /**
     * Activate / Deactivate course.
     */
    public function toggle(Course $course)
    {
        $course->update([

            'is_active' => !$course->is_active,

        ]);


        $message = $course->is_active
            ? 'Course / Programme activated successfully.'
            : 'Course / Programme deactivated successfully.';


        return back()
            ->with(
                'success',
                $message
            );
    }
}