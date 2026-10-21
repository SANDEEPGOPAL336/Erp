<?php

namespace App\Services;

use App\Models\AdmissionApplication;
use App\Models\CourseFeeComponent;
use App\Models\CourseFeeStructure;
use App\Models\FeeConcession;
use App\Models\StudentFeePayment;
use Illuminate\Database\Eloquent\Builder;

/**
 * Reads the balance inputs with locking/current reads.
 *
 * Callers must already hold the admission application row lock and be inside
 * the same transaction as the payment or concession state change. Fetching
 * matching rows with FOR UPDATE (instead of a plain SUM) avoids reusing an
 * InnoDB REPEATABLE READ snapshot established before the application lock.
 */
class AdmissionFeeBalance
{
    public function configuredFeeTotal(AdmissionApplication $application, int $semesterId): ?float
    {
        $components = CourseFeeComponent::query()
            ->where('course_id', $application->course_id)
            ->where('academic_session_id', $application->academic_session_id)
            ->where('is_active', true)
            ->where(function (Builder $query) use ($semesterId) {
                $query->whereNull('semester_id')
                    ->orWhere('semester_id', $semesterId);
            })
            ->orderBy('id')
            ->lockForUpdate()
            ->get(['id', 'amount']);

        $componentTotal = (float) $components->sum(
            fn (CourseFeeComponent $component) => (float) $component->amount
        );

        if ($componentTotal > 0) {
            return round($componentTotal, 2);
        }

        $legacy = CourseFeeStructure::query()
            ->where('course_id', $application->course_id)
            ->where('academic_session_id', $application->academic_session_id)
            ->lockForUpdate()
            ->first(['semester_fee']);

        return $legacy === null
            ? null
            : round((float) $legacy->semester_fee, 2);
    }

    public function verifiedPaymentTotal(AdmissionApplication $application, int $semesterId): float
    {
        $query = StudentFeePayment::query()
            ->where('admission_application_id', $application->id)
            ->where('status', 'verified');

        if ($application->semester_id === null && $semesterId === 0) {
            // Preserve the legacy first-fee behavior when the application has
            // no semester: its verified NULL-semester payments are the only
            // applicable legacy balance records.
            $query->whereNull('semester_id');
        } else {
            $query->where(function (Builder $payments) use ($semesterId) {
                $payments->where('semester_id', $semesterId)
                    ->orWhere(function (Builder $legacy) use ($semesterId) {
                        $legacy->whereNull('semester_id')
                            ->where(function (Builder $source) use ($semesterId) {
                                $source->whereHas('studentEnrollment', function (Builder $enrollment) use ($semesterId) {
                                    $enrollment->where('current_semester_id', $semesterId);
                                })->orWhereHas('admissionApplication', function (Builder $application) use ($semesterId) {
                                    $application->where('semester_id', $semesterId);
                                });
                            });
                    });
            });
        }

        $payments = $query
            ->orderBy('id')
            ->lockForUpdate()
            ->get(['id', 'amount_paid']);

        return round((float) $payments->sum(
            fn (StudentFeePayment $payment) => (float) $payment->amount_paid
        ), 2);
    }

    public function approvedConcessionTotal(
        int $applicationId,
        int $semesterId,
        ?int $exceptConcessionId = null
    ): float {
        $concessions = FeeConcession::query()
            ->where('admission_application_id', $applicationId)
            ->where('semester_id', $semesterId)
            ->where('status', 'approved')
            ->whereNotNull('approved_amount')
            ->when($exceptConcessionId !== null, function (Builder $query) use ($exceptConcessionId) {
                $query->whereKeyNot($exceptConcessionId);
            })
            ->orderBy('id')
            ->lockForUpdate()
            ->get(['id', 'approved_amount']);

        return round((float) $concessions->sum(
            fn (FeeConcession $concession) => (float) $concession->approved_amount
        ), 2);
    }
}
