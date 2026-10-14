<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('course_years')) {
            Schema::create('course_years', function (Blueprint $table) {
                $table->id();

                $table->foreignId('course_id')
                    ->constrained('courses')
                    ->cascadeOnDelete();

                $table->unsignedTinyInteger('year_number');

                $table->string('name', 100);

                $table->boolean('is_active')
                    ->default(true);

                $table->unsignedInteger('sort_order')
                    ->default(0);

                $table->timestamps();

                $table->unique(
                    ['course_id', 'year_number'],
                    'course_years_course_year_unique'
                );
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('course_years');
    }
};