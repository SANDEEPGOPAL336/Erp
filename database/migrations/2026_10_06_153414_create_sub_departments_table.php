<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Table already exists in the current ERP database.
        // Create it only when it does not exist.
        if (!Schema::hasTable('sub_departments')) {
            Schema::create('sub_departments', function (Blueprint $table) {
                $table->id();

                $table->foreignId('department_id')
                    ->constrained('departments')
                    ->cascadeOnDelete();

                $table->string('name', 150);
                $table->string('code', 50)->nullable();
                $table->boolean('is_active')->default(true);
                $table->unsignedInteger('sort_order')->default(0);

                $table->timestamps();
            });

            return;
        }

        /*
         * The table already existed before this migration.
         * Add only the columns that are missing.
         */
        if (!Schema::hasColumn('sub_departments', 'code')) {
            Schema::table('sub_departments', function (Blueprint $table) {
                $table->string('code', 50)->nullable()->after('name');
            });
        }

        if (!Schema::hasColumn('sub_departments', 'sort_order')) {
            Schema::table('sub_departments', function (Blueprint $table) {
                $table->unsignedInteger('sort_order')
                    ->default(0)
                    ->after('is_active');
            });
        }
    }

    public function down(): void
    {
        /*
         * Do not drop the existing table automatically.
         * The table existed before this migration.
         */
    }
};