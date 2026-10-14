<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('student_promotions')) {
            Schema::create('student_promotions', function (Blueprint $table) {

                $table->id();


                /*
                |--------------------------------------------------------------------------
                | Enrollment
                |--------------------------------------------------------------------------
                */

                $table->foreignId('student_enrollment_id')
                    ->constrained('student_enrollments')
                    ->cascadeOnDelete();


                /*
                |--------------------------------------------------------------------------
                | Previous Academic Position
                |--------------------------------------------------------------------------
                */

                $table->foreignId('from_session_id')
                    ->constrained('academic_sessions')
                    ->restrictOnDelete();

                $table->unsignedTinyInteger('from_year_number');

                $table->foreignId('from_semester_id')
                    ->nullable()
                    ->constrained('semesters')
                    ->restrictOnDelete();


                /*
                |--------------------------------------------------------------------------
                | New Academic Position
                |--------------------------------------------------------------------------
                */

                $table->foreignId('to_session_id')
                    ->constrained('academic_sessions')
                    ->restrictOnDelete();

                $table->unsignedTinyInteger('to_year_number');

                $table->foreignId('to_semester_id')
                    ->nullable()
                    ->constrained('semesters')
                    ->restrictOnDelete();


                /*
                |--------------------------------------------------------------------------
                | Promotion
                |--------------------------------------------------------------------------
                */

                $table->date('promoted_at');

                $table->string('status', 30)
                    ->default('promoted');

                $table->text('remarks')
                    ->nullable();

                $table->timestamps();


                /*
                |--------------------------------------------------------------------------
                | Index
                |--------------------------------------------------------------------------
                */

                $table->index([
                    'student_enrollment_id',
                    'to_session_id',
                ]);

            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('student_promotions');
    }
};