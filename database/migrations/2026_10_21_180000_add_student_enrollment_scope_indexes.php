<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    private const TABLE = 'student_enrollments';

    private const INDEXES = [
        [
            'name' => 'student_enrollments_course_session_year_idx',
            'columns' => ['course_id', 'academic_session_id', 'year_number'],
        ],
        [
            'name' => 'student_enrollments_session_status_idx',
            'columns' => ['academic_session_id', 'enrollment_status'],
        ],
    ];

    public function up(): void
    {
        if (! Schema::hasTable(self::TABLE)) {
            throw new RuntimeException('The student_enrollments table must exist before its scope indexes can be added.');
        }

        foreach (self::INDEXES as $index) {
            $existingIndexes = Schema::getIndexes(self::TABLE);

            // Match the ordered column list, not just a name: an equivalent index
            // may already exist under a different name on an older installation.
            $hasEquivalentIndex = collect($existingIndexes)->contains(
                fn (array $existing): bool => array_values($existing['columns'] ?? []) === $index['columns']
            );

            if ($hasEquivalentIndex) {
                continue;
            }

            $nameIsAlreadyUsed = collect($existingIndexes)->contains(
                fn (array $existing): bool => ($existing['name'] ?? null) === $index['name']
            );

            if ($nameIsAlreadyUsed) {
                throw new RuntimeException("Index name {$index['name']} is already used for a different column list.");
            }

            Schema::table(self::TABLE, function (Blueprint $table) use ($index): void {
                $table->index($index['columns'], $index['name']);
            });
        }
    }

    public function down(): void
    {
        // These are additive, non-unique performance indexes. The schema cannot
        // tell us whether an equivalent index predated this migration, so retain
        // them on rollback rather than risk dropping an index owned by the app.
    }
};
