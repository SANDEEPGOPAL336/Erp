<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    private const COURSE_SESSION_YEAR_INDEX = 'student_enrollments_course_session_year_idx';

    private const SESSION_STATUS_INDEX = 'student_enrollments_session_status_idx';

    public function up(): void
    {
        if (!Schema::hasTable('student_enrollments')) {
            Schema::create('student_enrollments', function (Blueprint $table) {

                $table->id();

                /*
                |--------------------------------------------------------------------------
                | Student
                |--------------------------------------------------------------------------
                */

                $table->foreignId('user_id')
                    ->constrained('users')
                    ->cascadeOnDelete();


                /*
                |--------------------------------------------------------------------------
                | Admission Application
                |--------------------------------------------------------------------------
                */

                $table->foreignId('admission_application_id')
                    ->nullable()
                    ->unique()
                    ->constrained('admission_applications')
                    ->nullOnDelete();


                /*
                |--------------------------------------------------------------------------
                | Programme
                |--------------------------------------------------------------------------
                */

                $table->foreignId('course_id')
                    ->constrained('courses')
                    ->restrictOnDelete();


                /*
                |--------------------------------------------------------------------------
                | Academic Session
                |--------------------------------------------------------------------------
                */

                $table->foreignId('academic_session_id')
                    ->constrained('academic_sessions')
                    ->restrictOnDelete();


                /*
                |--------------------------------------------------------------------------
                | Current Academic Year
                |--------------------------------------------------------------------------
                */

                $table->unsignedTinyInteger('year_number');


                /*
                |--------------------------------------------------------------------------
                | Current Semester
                |--------------------------------------------------------------------------
                |
                | NULL for yearly programmes.
                |
                */

                $table->foreignId('current_semester_id')
                    ->nullable()
                    ->constrained('semesters')
                    ->restrictOnDelete();


                /*
                |--------------------------------------------------------------------------
                | College / Roll Information
                |--------------------------------------------------------------------------
                */

                $table->string('college_number', 100)
                    ->nullable()
                    ->unique();

                $table->string('roll_number', 100)
                    ->nullable()
                    ->unique();


                /*
                |--------------------------------------------------------------------------
                | Enrollment Status
                |--------------------------------------------------------------------------
                */

                $table->string('enrollment_status', 30)
                    ->default('active');


                /*
                |--------------------------------------------------------------------------
                | Dates
                |--------------------------------------------------------------------------
                */

                $table->date('enrollment_date')
                    ->nullable();

                $table->date('completion_date')
                    ->nullable();


                /*
                |--------------------------------------------------------------------------
                | Remarks
                |--------------------------------------------------------------------------
                */

                $table->text('remarks')
                    ->nullable();

                $table->timestamps();


                /*
                |--------------------------------------------------------------------------
                | Useful Index
                |--------------------------------------------------------------------------
                */

                $table->index(
                    ['course_id', 'academic_session_id', 'year_number'],
                    self::COURSE_SESSION_YEAR_INDEX
                );

                $table->index(
                    ['academic_session_id', 'enrollment_status'],
                    self::SESSION_STATUS_INDEX
                );

            });
        }

        // MariaDB may have left the table behind after an earlier DDL error.
        // Ensure the intended indexes also exist when resuming that migration.
        $this->ensureIndex(
            self::COURSE_SESSION_YEAR_INDEX,
            ['course_id', 'academic_session_id', 'year_number']
        );
        $this->ensureIndex(
            self::SESSION_STATUS_INDEX,
            ['academic_session_id', 'enrollment_status']
        );
    }

    private function ensureIndex(string $name, array $columns): void
    {
        $exists = collect(Schema::getIndexes('student_enrollments'))
            ->contains(fn (array $index): bool => $index['columns'] === $columns);

        if (!$exists) {
            Schema::table('student_enrollments', function (Blueprint $table) use ($name, $columns) {
                $table->index($columns, $name);
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('student_enrollments');
    }
};
