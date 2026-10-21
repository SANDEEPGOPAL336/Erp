<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    private const INDEX = 'student_enrollments_application_unique';

    public function up(): void
    {
        if (!Schema::hasTable('student_enrollments')) {
            return;
        }

        $duplicates = DB::table('student_enrollments')
            ->select('admission_application_id')
            ->whereNotNull('admission_application_id')
            ->groupBy('admission_application_id')
            ->havingRaw('COUNT(*) > 1')
            ->pluck('admission_application_id')
            ->all();

        if ($duplicates !== []) {
            throw new RuntimeException(
                'Cannot add the student enrollment application unique index; duplicate admission_application_id values exist: '
                . implode(', ', $duplicates)
                . '. Reconcile the duplicate enrollments before rerunning this migration.'
            );
        }

        $hasUniqueIndex = collect(Schema::getIndexes('student_enrollments'))
            ->contains(function (array $index): bool {
                return $index['unique']
                    && $index['columns'] === ['admission_application_id'];
            });

        if (!$hasUniqueIndex) {
            Schema::table('student_enrollments', function (Blueprint $table) {
                $table->unique('admission_application_id', self::INDEX);
            });
        }
    }

    public function down(): void
    {
        if (!Schema::hasTable('student_enrollments')) {
            return;
        }

        $hasIndex = collect(Schema::getIndexes('student_enrollments'))
            ->contains(fn (array $index): bool => $index['name'] === self::INDEX);

        if ($hasIndex) {
            Schema::table('student_enrollments', function (Blueprint $table) {
                $table->dropUnique(self::INDEX);
            });
        }
    }
};
