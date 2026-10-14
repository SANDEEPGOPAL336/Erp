<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasColumn('courses', 'study_pattern')) {
            Schema::table('courses', function (Blueprint $table) {
                $table->string('study_pattern', 20)
                    ->nullable()
                    ->after('duration');
            });
        }

        if (!Schema::hasColumn('courses', 'total_years')) {
            Schema::table('courses', function (Blueprint $table) {
                $table->unsignedTinyInteger('total_years')
                    ->nullable()
                    ->after('study_pattern');
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasColumn('courses', 'total_years')) {
            Schema::table('courses', function (Blueprint $table) {
                $table->dropColumn('total_years');
            });
        }

        if (Schema::hasColumn('courses', 'study_pattern')) {
            Schema::table('courses', function (Blueprint $table) {
                $table->dropColumn('study_pattern');
            });
        }
    }
};