<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        /*
        |--------------------------------------------------------------------------
        | Academic Sessions
        |--------------------------------------------------------------------------
        */

        Schema::create('academic_sessions', function (Blueprint $table) {

            $table->id();

            $table->string('name')->unique();

            $table->date('start_date')->nullable();

            $table->date('end_date')->nullable();

            $table->boolean('is_active')->default(false);

            $table->timestamps();
        });


        /*
        |--------------------------------------------------------------------------
        | Departments
        |--------------------------------------------------------------------------
        */

        Schema::create('departments', function (Blueprint $table) {

            $table->id();

            $table->string('name');

            $table->string('code')
                ->nullable()
                ->unique();

            $table->boolean('is_active')
                ->default(true);

            $table->timestamps();
        });


        /*
        |--------------------------------------------------------------------------
        | Sub Departments
        |--------------------------------------------------------------------------
        */

        Schema::create('sub_departments', function (Blueprint $table) {

            $table->id();

            $table->foreignId('department_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->string('name');

            $table->boolean('is_active')
                ->default(true);

            $table->timestamps();
        });


        /*
        |--------------------------------------------------------------------------
        | Courses
        |--------------------------------------------------------------------------
        */

        Schema::create('courses', function (Blueprint $table) {

            $table->id();

            $table->foreignId('department_id')
                ->nullable()
                ->constrained()
                ->nullOnDelete();

            $table->string('name');

            $table->string('code')
                ->unique();

            $table->string('duration')
                ->nullable();

            $table->decimal('admission_fee', 10, 2)
                ->default(0);

            $table->decimal('annual_fee', 10, 2)
                ->default(0);

            $table->boolean('is_active')
                ->default(true);

            $table->timestamps();
        });


        /*
        |--------------------------------------------------------------------------
        | Semesters
        |--------------------------------------------------------------------------
        */

        Schema::create('semesters', function (Blueprint $table) {

            $table->id();

            $table->string('name');

            $table->unsignedTinyInteger(
                'semester_number'
            );

            $table->boolean('is_active')
                ->default(true);

            $table->timestamps();

            $table->unique('semester_number');
        });


        /*
        |--------------------------------------------------------------------------
        | Subjects
        |--------------------------------------------------------------------------
        */

        Schema::create('subjects', function (Blueprint $table) {

            $table->id();

            $table->foreignId('course_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->foreignId('semester_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->string('name');

            $table->string('code');

            $table->string('subject_type')
                ->default('DSC');

            $table->boolean('is_active')
                ->default(true);

            $table->timestamps();

            $table->unique([
                'course_id',
                'semester_id',
                'code'
            ]);
        });


        /*
        |--------------------------------------------------------------------------
        | Staff Profiles
        |--------------------------------------------------------------------------
        */

        Schema::create('staff_profiles', function (Blueprint $table) {

            $table->id();

            $table->foreignId('user_id')
                ->unique()
                ->constrained()
                ->cascadeOnDelete();

            $table->string('employee_code')
                ->unique();

            $table->string('designation')
                ->nullable();

            $table->foreignId('department_id')
                ->nullable()
                ->constrained()
                ->nullOnDelete();

            $table->foreignId('sub_department_id')
                ->nullable()
                ->constrained()
                ->nullOnDelete();

            $table->date('joining_date')
                ->nullable();

            $table->string('profile_photo')
                ->nullable();

            $table->boolean('is_active')
                ->default(true);

            $table->timestamps();
        });


        /*
        |--------------------------------------------------------------------------
        | Staff Assignments
        |--------------------------------------------------------------------------
        */

        Schema::create('staff_assignments', function (Blueprint $table) {

            $table->id();

            $table->foreignId('staff_profile_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->foreignId('academic_session_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->foreignId('course_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->foreignId('semester_id')
                ->nullable()
                ->constrained()
                ->nullOnDelete();

            $table->string('role_type');

            $table->boolean('is_active')
                ->default(true);

            $table->timestamps();
        });


        /*
        |--------------------------------------------------------------------------
        | Student Profiles
        |--------------------------------------------------------------------------
        */

        Schema::create('student_profiles', function (Blueprint $table) {

            $table->id();

            $table->foreignId('user_id')
                ->unique()
                ->constrained()
                ->cascadeOnDelete();

            $table->string('registration_no')
                ->unique();

            $table->foreignId('course_id')
                ->nullable()
                ->constrained()
                ->nullOnDelete();

            $table->text('aadhaar_no')
                ->nullable();

            $table->string('father_name')
                ->nullable();

            $table->string('father_mobile')
                ->nullable();

            $table->string('mother_name')
                ->nullable();

            $table->string('mother_mobile')
                ->nullable();

            $table->string('alternate_mobile')
                ->nullable();

            $table->date('date_of_birth')
                ->nullable();

            $table->string('gender')
                ->nullable();

            $table->string('blood_group')
                ->nullable();

            $table->string('marital_status')
                ->nullable();

            $table->string('category')
                ->nullable();

            $table->string('sub_category')
                ->nullable();

            $table->string('religion')
                ->nullable();

            $table->string('nationality')
                ->default('Indian');

            $table->text('permanent_address')
                ->nullable();

            $table->string('permanent_post_office')
                ->nullable();

            $table->string('permanent_tehsil')
                ->nullable();

            $table->string('permanent_district')
                ->nullable();

            $table->string('permanent_state')
                ->nullable();

            $table->string('permanent_country')
                ->default('India');

            $table->string('permanent_pin_code')
                ->nullable();

            $table->boolean(
                'same_correspondence_address'
            )->default(false);

            $table->text('correspondence_address')
                ->nullable();

            $table->string(
                'correspondence_post_office'
            )->nullable();

            $table->string(
                'correspondence_tehsil'
            )->nullable();

            $table->string(
                'correspondence_district'
            )->nullable();

            $table->string(
                'correspondence_state'
            )->nullable();

            $table->string(
                'correspondence_country'
            )->default('India');

            $table->string(
                'correspondence_pin_code'
            )->nullable();

            $table->boolean('irdp_bpl')->default(false);

            $table->boolean('sports_quota')->default(false);

            $table->boolean(
                'himachali_bonafide'
            )->default(false);

            $table->boolean(
                'cultural_quota'
            )->default(false);

            $table->boolean(
                'minority_region'
            )->default(false);

            $table->boolean(
                'physically_challenged'
            )->default(false);

            $table->boolean(
                'gap_after_12th'
            )->default(false);

            $table->boolean(
                'single_girl_child'
            )->default(false);

            $table->boolean('ncc')->default(false);

            $table->boolean('nss')->default(false);

            $table->boolean('punished')->default(false);

            $table->boolean(
                'related_student'
            )->default(false);

            $table->boolean(
                'serious_illness'
            )->default(false);

            $table->boolean(
                'sports_cultural_distinction'
            )->default(false);

            $table->string('profile_image')
                ->nullable();

            $table->string('signature_image')
                ->nullable();

            $table->timestamps();
        });


        /*
        |--------------------------------------------------------------------------
        | Admission Applications
        |--------------------------------------------------------------------------
        */

        Schema::create('admission_applications', function (Blueprint $table) {

            $table->id();

            $table->foreignId('user_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->foreignId('academic_session_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->foreignId('course_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->foreignId('semester_id')
                ->nullable()
                ->constrained()
                ->nullOnDelete();

            $table->string('application_no')
                ->unique();

            $table->string('admission_type')
                ->default('New');

            $table->string('status')
                ->default('draft');

            $table->foreignId('reviewed_by')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            $table->text('review_remarks')
                ->nullable();

            $table->timestamp('reviewed_at')
                ->nullable();

            $table->timestamp('submitted_at')
                ->nullable();

            $table->timestamps();
        });


        /*
        |--------------------------------------------------------------------------
        | Student Qualifications
        |--------------------------------------------------------------------------
        */

        Schema::create('student_qualifications', function (Blueprint $table) {

            $table->id();

            $table->foreignId('student_profile_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->string('qualification_name');

            $table->string('subjects_stream')
                ->nullable();

            $table->string('university_board')
                ->nullable();

            $table->string('board_roll_no')
                ->nullable();

            $table->string('school_institute')
                ->nullable();

            $table->string('result_type')
                ->nullable();

            $table->year('passing_year')
                ->nullable();

            $table->decimal(
                'obtained_marks',
                10,
                2
            )->nullable();

            $table->decimal(
                'total_marks',
                10,
                2
            )->nullable();

            $table->decimal(
                'percentage',
                6,
                2
            )->nullable();

            $table->boolean('is_active')
                ->default(true);

            $table->timestamps();
        });


        /*
        |--------------------------------------------------------------------------
        | Application Subjects
        |--------------------------------------------------------------------------
        */

        Schema::create('application_subjects', function (Blueprint $table) {

            $table->id();

            $table->foreignId(
                'admission_application_id'
            )
            ->constrained()
            ->cascadeOnDelete();

            $table->foreignId('subject_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->unsignedTinyInteger(
                'position'
            )->default(1);

            $table->timestamps();

            $table->unique([
                'admission_application_id',
                'subject_id'
            ]);
        });


        /*
        |--------------------------------------------------------------------------
        | Student Documents
        |--------------------------------------------------------------------------
        */

        Schema::create('student_documents', function (Blueprint $table) {

            $table->id();

            $table->foreignId('student_profile_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->string('document_name');

            $table->string('file_path');

            $table->boolean('is_active')
                ->default(true);

            $table->timestamps();
        });


        /*
        |--------------------------------------------------------------------------
        | Fee Payments
        |--------------------------------------------------------------------------
        */

        Schema::create('fee_payments', function (Blueprint $table) {

            $table->id();

            $table->foreignId(
                'admission_application_id'
            )
            ->constrained()
            ->cascadeOnDelete();

            $table->unsignedInteger(
                'installment_no'
            )->default(1);

            $table->decimal(
                'amount',
                10,
                2
            );

            $table->string(
                'payment_mode'
            );

            $table->string(
                'transaction_id'
            )->nullable();

            $table->string(
                'receipt_path'
            )->nullable();

            $table->string(
                'status'
            )->default('pending');

            $table->foreignId(
                'verified_by'
            )
            ->nullable()
            ->constrained('users')
            ->nullOnDelete();

            $table->timestamp(
                'verified_at'
            )->nullable();

            $table->timestamps();
        });


        /*
        |--------------------------------------------------------------------------
        | Enrollments
        |--------------------------------------------------------------------------
        */

        Schema::create('enrollments', function (Blueprint $table) {

            $table->id();

            $table->foreignId(
                'admission_application_id'
            )
            ->unique()
            ->constrained()
            ->cascadeOnDelete();

            $table->string(
                'college_no'
            )->unique();

            $table->string(
                'roll_no'
            )->unique();

            $table->timestamp(
                'enrolled_at'
            )->nullable();

            $table->timestamps();
        });
    }


    public function down(): void
    {
        Schema::dropIfExists('enrollments');

        Schema::dropIfExists('fee_payments');

        Schema::dropIfExists('student_documents');

        Schema::dropIfExists('application_subjects');

        Schema::dropIfExists('student_qualifications');

        Schema::dropIfExists('admission_applications');

        Schema::dropIfExists('student_profiles');

        Schema::dropIfExists('staff_assignments');

        Schema::dropIfExists('staff_profiles');

        Schema::dropIfExists('subjects');

        Schema::dropIfExists('semesters');

        Schema::dropIfExists('courses');

        Schema::dropIf_exists('sub_departments');

        Schema::dropIfExists('departments');

        Schema::dropIfExists('academic_sessions');
    }
};