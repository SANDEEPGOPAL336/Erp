<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\StaffProfile;
use App\Models\StaffAssignment;
use App\Models\AcademicSession;
use App\Models\Course;
use App\Models\Semester;

class DummyStaffSeeder extends Seeder
{
    public function run(): void
    {
        /*
        |--------------------------------------------------------------------------
        | Find Academic Session
        |--------------------------------------------------------------------------
        */

        $session = AcademicSession::where(
            'name',
            '2026-27'
        )->first();

        if (!$session) {
            $this->command->error(
                'Academic Session 2026-27 not found.'
            );

            return;
        }


        /*
        |--------------------------------------------------------------------------
        | Find Course
        |--------------------------------------------------------------------------
        */

        $course = Course::where(
            'code',
            'BCA'
        )->first();

        if (!$course) {
            $this->command->error(
                'BCA course not found.'
            );

            return;
        }


        /*
        |--------------------------------------------------------------------------
        | Find Semester
        |--------------------------------------------------------------------------
        */

        $semester = Semester::where(
            'semester_number',
            1
        )->first();

        if (!$semester) {
            $this->command->error(
                'Semester 1 not found.'
            );

            return;
        }


        /*
        |--------------------------------------------------------------------------
        | Create / Update Dummy Staff User
        |--------------------------------------------------------------------------
        */

        $user = User::updateOrCreate(
            [
                'email' => 'staff@college.local'
            ],
            [
                'name' => 'Dummy Unit Teacher',
                'password' => 'Staff@12345',
                'role' => 'staff',
                'phone' => '9876543210',
                'is_active' => true,
            ]
        );


        /*
        |--------------------------------------------------------------------------
        | Create / Update Staff Profile
        |--------------------------------------------------------------------------
        */

        $staffProfile = StaffProfile::updateOrCreate(
            [
                'user_id' => $user->id
            ],
            [
                'employee_code' => 'ST001',
                'designation' => 'Unit Teacher',
                'department_id' => $course->department_id,
                'sub_department_id' => null,
                'joining_date' => now()->toDateString(),
                'profile_photo' => null,
                'is_active' => true,
            ]
        );


        /*
        |--------------------------------------------------------------------------
        | Create / Update Staff Assignment
        |--------------------------------------------------------------------------
        */

        StaffAssignment::updateOrCreate(
            [
                'staff_profile_id' => $staffProfile->id,
                'academic_session_id' => $session->id,
                'course_id' => $course->id,
                'semester_id' => $semester->id,
            ],
            [
                'role_type' => 'Unit Teacher',
                'is_active' => true,
            ]
        );


        /*
        |--------------------------------------------------------------------------
        | Success Message
        |--------------------------------------------------------------------------
        */

        $this->command->info(
            'Dummy Staff account created successfully.'
        );

        $this->command->info(
            'Email: staff@college.local'
        );

        $this->command->info(
            'Password: Staff@12345'
        );

        $this->command->info(
            'Employee Code: ST001'
        );

        $this->command->info(
            'Assigned Course: BCA'
        );

        $this->command->info(
            'Assigned Semester: 1'
        );
    }
}