<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('course_year_semesters')) {
            Schema::create('course_year_semesters', function (Blueprint $table) {
                $table->id();

                $table->foreignId('course_year_id')
                    ->constrained('course_years')
                    ->cascadeOnDelete();

                $table->foreignId('semester_id')
                    ->constrained('semesters')
                    ->restrictOnDelete();

                $table->boolean('is_active')
                    ->default(true);

                $table->timestamps();

                $table->unique(
                    ['course_year_id', 'semester_id'],
                    'course_year_semester_unique'
                );
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('course_year_semesters');
    }
};