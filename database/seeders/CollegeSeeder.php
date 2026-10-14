<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Course;
use App\Models\Semester;
use App\Models\Department;
use App\Models\AcademicSession;
use Illuminate\Database\Seeder;

class CollegeSeeder extends Seeder
{
    public function run(): void
    {
        /*
        |--------------------------------------------------------------------------
        | Admin Account
        |--------------------------------------------------------------------------
        */

        User::create([
            'name' => 'College Administrator',
            'email' => 'admin@college.local',
            'password' => 'Admin@12345',
            'role' => 'admin',
            'phone' => '9999999999',
            'is_active' => true,
        ]);


        /*
        |--------------------------------------------------------------------------
        | Academic Session
        |--------------------------------------------------------------------------
        */

        AcademicSession::create([
            'name' => '2026-27',
            'start_date' => '2026-07-01',
            'end_date' => '2027-06-30',
            'is_active' => true,
        ]);


        /*
        |--------------------------------------------------------------------------
        | Departments
        |--------------------------------------------------------------------------
        */

        $cs = Department::create([
            'name' => 'Computer Science',
            'code' => 'CS',
            'is_active' => true,
        ]);

        $commerce = Department::create([
            'name' => 'Commerce',
            'code' => 'COM',
            'is_active' => true,
        ]);

        $arts = Department::create([
            'name' => 'Arts',
            'code' => 'ARTS',
            'is_active' => true,
        ]);


        /*
        |--------------------------------------------------------------------------
        | Courses
        |--------------------------------------------------------------------------
        */

        Course::create([
            'department_id' => $cs->id,
            'name' => 'Bachelor of Computer Applications',
            'code' => 'BCA',
            'duration' => '3 Years',
            'admission_fee' => 500,
            'annual_fee' => 30000,
            'is_active' => true,
        ]);

        Course::create([
            'department_id' => $commerce->id,
            'name' => 'Bachelor of Commerce',
            'code' => 'BCOM',
            'duration' => '3 Years',
            'admission_fee' => 500,
            'annual_fee' => 25000,
            'is_active' => true,
        ]);

        Course::create([
            'department_id' => $arts->id,
            'name' => 'Bachelor of Arts',
            'code' => 'BA',
            'duration' => '3 Years',
            'admission_fee' => 500,
            'annual_fee' => 20000,
            'is_active' => true,
        ]);

        Course::create([
            'department_id' => null,
            'name' => 'B.Sc. Medical',
            'code' => 'BSCMED',
            'duration' => '3 Years',
            'admission_fee' => 500,
            'annual_fee' => 25000,
            'is_active' => true,
        ]);

        Course::create([
            'department_id' => null,
            'name' => 'B.Sc. Non-Medical',
            'code' => 'BSCNM',
            'duration' => '3 Years',
            'admission_fee' => 500,
            'annual_fee' => 25000,
            'is_active' => true,
        ]);

        Course::create([
            'department_id' => null,
            'name' => 'Bachelor of Business Administration',
            'code' => 'BBA',
            'duration' => '3 Years',
            'admission_fee' => 500,
            'annual_fee' => 28000,
            'is_active' => true,
        ]);


        /*
        |--------------------------------------------------------------------------
        | Semesters
        |--------------------------------------------------------------------------
        */

        for ($i = 1; $i <= 6; $i++) {

            Semester::create([
                'name' => (string) $i,
                'semester_number' => $i,
                'is_active' => true,
            ]);
        }
    }
}