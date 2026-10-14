<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        $now = now();

        DB::table('semesters')->updateOrInsert(
            ['semester_number' => 7],
            [
                'name' => '7',
                'is_active' => true,
                'updated_at' => $now,
                'created_at' => $now,
            ]
        );

        DB::table('semesters')->updateOrInsert(
            ['semester_number' => 8],
            [
                'name' => '8',
                'is_active' => true,
                'updated_at' => $now,
                'created_at' => $now,
            ]
        );
    }

    public function down(): void
    {
        DB::table('semesters')
            ->whereIn('semester_number', [7, 8])
            ->delete();
    }
};