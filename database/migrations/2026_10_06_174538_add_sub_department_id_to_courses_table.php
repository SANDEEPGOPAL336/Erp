<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (
            Schema::hasTable('courses') &&
            !Schema::hasColumn('courses', 'sub_department_id')
        ) {

            Schema::table('courses', function (Blueprint $table) {

                $table->foreignId('sub_department_id')
                    ->nullable()
                    ->after('department_id')
                    ->constrained('sub_departments')
                    ->nullOnDelete();

            });
        }
    }

    public function down(): void
    {
        if (
            Schema::hasTable('courses') &&
            Schema::hasColumn('courses', 'sub_department_id')
        ) {

            Schema::table('courses', function (Blueprint $table) {

                $table->dropForeign([
                    'sub_department_id'
                ]);

                $table->dropColumn('sub_department_id');

            });
        }
    }
};