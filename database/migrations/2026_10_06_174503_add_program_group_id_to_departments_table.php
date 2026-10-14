<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (
            Schema::hasTable('departments') &&
            !Schema::hasColumn('departments', 'program_group_id')
        ) {

            Schema::table('departments', function (Blueprint $table) {

                $table->foreignId('program_group_id')
                    ->nullable()
                    ->after('id')
                    ->constrained('program_groups')
                    ->nullOnDelete();

            });
        }
    }

    public function down(): void
    {
        if (
            Schema::hasTable('departments') &&
            Schema::hasColumn('departments', 'program_group_id')
        ) {

            Schema::table('departments', function (Blueprint $table) {

                $table->dropForeign([
                    'program_group_id'
                ]);

                $table->dropColumn('program_group_id');

            });
        }
    }
};