<?php

namespace App\Http\Controllers;

use App\Models\AdmissionApplication;
use App\Models\CourseFeeComponent;
use App\Models\CourseFeeStructure;
use App\Models\FeeConcession;
use App\Models\StudentEnrollment;
use App\Models\StudentFeePayment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class AdminFeeConcessionController extends Controller
{
    /**
     * Ensure that only an admin can manage fee concessions.
     */
    private function ensureAdmin(): void
    {
        $user = auth()->user();

        abort_unless(
            $user && strtolower((string) $user->role) === 'admin',
            403,
            'Only an administrator can manage fee concessions.'
        );
    }

    /**
     * Display concession requests.
     */
    public function index(Request $request)
    {
        $this->ensureAdmin();

        $query = FeeConcession::with([
            'admissionApplication',
            'studentEnrollment',
            'semester',
            'requester',
            'approver',
            'rejector',
        ])->latest();

        $allowedStatuses = ['pending', 'approved', 'rejected'];

        if (
            $request->filled('status') &&
            in_array($request->input('status'), $allowedStatuses, true)
        ) {
            $query->where('status', $request->input('status'));
        }

        $concessions = $query->get();

        return view('admin.fee-concessions.index', [
            'concessions' => $concessions,
        ]);
    }

    /**
     * Approve a concession using the approved percentage or fixed amount.
     */
    public function approve(Request $request, int $concessionId)
    {
        $this->ensureAdmin();

        $validated = $request->validate([
            'approved_value' => [
                'required',
                'numeric',
                'gt:0',
            ],
            'decision_remarks' => [
                'nullable',
                'string',
                'max:1000',
            ],
        ]);

        // Resolve the application outside the transaction only to learn which
        // mutex to acquire. No fee/balance state is read until after that lock.
        $preview = FeeConcession::query()
            ->with('studentEnrollment')
            ->whereKey($concessionId)
            ->firstOrFail();
        $applicationId = $preview->admission_application_id
            ?? $preview->studentEnrollment?->admission_application_id;
        $enrollmentId = $preview->student_enrollment_id;

        DB::transaction(function () use (
            $validated,
            $concessionId,
            $applicationId,
            $enrollmentId
        ) {
            // Canonical order: admission application, then fee rows.
            if ($applicationId) {
                AdmissionApplication::query()
                    ->whereKey($applicationId)
                    ->lockForUpdate()
                    ->firstOrFail();
            } elseif ($enrollmentId) {
                StudentEnrollment::query()
                    ->whereKey($enrollmentId)
                    ->lockForUpdate()
                    ->firstOrFail();
            }

            $concession = FeeConcession::whereKey($concessionId)
                ->lockForUpdate()
                ->firstOrFail();

            if ((int) ($concession->admission_application_id
                    ?? $concession->studentEnrollment?->admission_application_id)
                !== (int) ($applicationId ?? 0)) {
                throw ValidationException::withMessages([
                    'status' => 'The concession application changed while it was being reviewed. Refresh and try again.',
                ]);
            }

            if ($concession->status !== 'pending') {
                throw ValidationException::withMessages([
                    'status' => 'Only pending concession requests can be approved.',
                ]);
            }

            $calculationType = strtolower(
                trim((string) $concession->calculation_type)
            );

            $isPercentage = in_array(
                $calculationType,
                ['percentage', 'percent', '%'],
                true
            );

            $isFixedAmount = in_array(
                $calculationType,
                ['fixed', 'fixed_amount', 'amount', 'flat'],
                true
            );

            if (!$isPercentage && !$isFixedAmount) {
                throw ValidationException::withMessages([
                    'approved_value' =>
                        'The concession calculation type is not supported. Check the stored calculation type.',
                ]);
            }

            $approvedValue = (float) $validated['approved_value'];

            if ($isPercentage && $approvedValue > 100) {
                throw ValidationException::withMessages([
                    'approved_value' =>
                        'An approved concession percentage cannot exceed 100%.',
                ]);
            }

            $application = $concession->admissionApplication;
            $enrollment = $concession->studentEnrollment;

            $courseId = $application?->course_id
                ?? $enrollment?->course_id;

            $sessionId = $application?->academic_session_id
                ?? $enrollment?->academic_session_id;

            $semesterId = $concession->semester_id
                ?? $application?->semester_id
                ?? $enrollment?->semester_id;

            if (!$courseId || !$sessionId || !$semesterId) {
                throw ValidationException::withMessages([
                    'approved_value' =>
                        'The course, academic session, or semester is missing. Check the concession record before approving.',
                ]);
            }

            /*
             * Calculate the semester fee using active fee components.
             * Semester-specific and general (NULL semester) components
             * are both included, matching the dashboard's fee structure.
             */
            $components = CourseFeeComponent::query()
                ->where('course_id', $courseId)
                ->where('academic_session_id', $sessionId)
                ->where('is_active', true)
                ->where(function ($query) use ($semesterId) {
                    $query->where('semester_id', $semesterId)
                        ->orWhereNull('semester_id');
                })
                ->orderBy('id')
                ->lockForUpdate()
                ->get(['id', 'amount']);
            $baseFee = (float) $components->sum(
                fn (CourseFeeComponent $component) => (float) $component->amount
            );

            /*
             * Fall back to the existing legacy semester fee structure.
             */
            if ($baseFee <= 0) {
                $baseFee = (float) CourseFeeStructure::query()
                    ->where('course_id', $courseId)
                    ->where('academic_session_id', $sessionId)
                    ->lockForUpdate()
                    ->first(['semester_fee'])
                    ?->semester_fee;
            }

            if ($baseFee <= 0) {
                throw ValidationException::withMessages([
                    'approved_value' =>
                        'No semester fee is configured for this course and academic session.',
                ]);
            }

            $approvedAmount = $isPercentage
                ? round($baseFee * $approvedValue / 100, 2)
                : round($approvedValue, 2);

            /*
             * Subtract verified payments and previously approved concessions
             * before deciding whether the new concession fits the balance.
             * Legacy payments with a NULL semester are included for
             * compatibility with the current student dashboard.
             */
            $verifiedPaid = 0.0;

            if ($application) {
                $paymentQuery = StudentFeePayment::query()
                    ->where(
                        'admission_application_id',
                        $application->id
                    )
                    ->where('status', 'verified')
                    ->where(function ($query) use ($semesterId) {
                        $query->where('semester_id', $semesterId)
                            ->orWhereNull('semester_id');
                    })
                    ->orderBy('id')
                    ->lockForUpdate();

                $verifiedPaid = (float) $paymentQuery
                    ->get(['id', 'amount_paid'])
                    ->sum(fn (StudentFeePayment $payment) => (float) $payment->amount_paid);
            }

            $otherConcessions = FeeConcession::query()
                ->where('status', 'approved')
                ->whereKeyNot($concession->id)
                ->where(function ($query) use ($semesterId) {
                    $query->where('semester_id', $semesterId)
                        ->orWhereNull('semester_id');
                })
                ->where(function ($query) use ($application, $enrollment) {
                    if ($application) {
                        $query->where(
                            'admission_application_id',
                            $application->id
                        );
                    } else {
                        $query->where(
                            'student_enrollment_id',
                            $enrollment?->id
                        );
                    }
                })
                ->orderBy('id')
                ->lockForUpdate()
                ->get(['id', 'approved_amount'])
                ->sum(fn (FeeConcession $other) => (float) $other->approved_amount);

            $remainingBalance = max(
                0,
                $baseFee - $verifiedPaid - (float) $otherConcessions
            );

            if ($approvedAmount > $remainingBalance + 0.0001) {
                throw ValidationException::withMessages([
                    'approved_value' => sprintf(
                        'The approved concession (₹%.2f) exceeds the remaining payable balance (₹%.2f).',
                        $approvedAmount,
                        $remainingBalance
                    ),
                ]);
            }

            $concession->approved_value = $approvedValue;
            $concession->approved_amount = $approvedAmount;
            $concession->status = 'approved';
            $concession->approved_by = auth()->id();
            $concession->approved_at = now();
            $concession->decision_remarks =
                $validated['decision_remarks'] ?? null;

            $concession->save();
        }, 3);

        return redirect()
            ->route('admin.fee-concessions.index')
            ->with('success', 'Fee concession approved successfully.');
    }

    /**
     * Reject a pending concession with a mandatory decision reason.
     */
    public function reject(Request $request, int $concessionId)
    {
        $this->ensureAdmin();

        $validated = $request->validate([
            'decision_remarks' => [
                'required',
                'string',
                'min:3',
                'max:1000',
            ],
        ]);

        $preview = FeeConcession::query()
            ->with('studentEnrollment')
            ->whereKey($concessionId)
            ->firstOrFail();
        $applicationId = $preview->admission_application_id
            ?? $preview->studentEnrollment?->admission_application_id;
        $enrollmentId = $preview->student_enrollment_id;

        DB::transaction(function () use (
            $validated,
            $concessionId,
            $applicationId,
            $enrollmentId
        ) {
            if ($applicationId) {
                AdmissionApplication::query()
                    ->whereKey($applicationId)
                    ->lockForUpdate()
                    ->firstOrFail();
            } elseif ($enrollmentId) {
                StudentEnrollment::query()
                    ->whereKey($enrollmentId)
                    ->lockForUpdate()
                    ->firstOrFail();
            }

            $concession = FeeConcession::whereKey($concessionId)
                ->lockForUpdate()
                ->firstOrFail();

            if ((int) ($concession->admission_application_id
                    ?? $concession->studentEnrollment?->admission_application_id)
                !== (int) ($applicationId ?? 0)) {
                throw ValidationException::withMessages([
                    'status' => 'The concession application changed while it was being reviewed. Refresh and try again.',
                ]);
            }

            if ($concession->status !== 'pending') {
                throw ValidationException::withMessages([
                    'status' => 'Only pending concession requests can be rejected.',
                ]);
            }

            $concession->status = 'rejected';
            $concession->rejected_by = auth()->id();
            $concession->rejected_at = now();
            $concession->decision_remarks =
                $validated['decision_remarks'];

            $concession->save();
        }, 3);

        return redirect()
            ->route('admin.fee-concessions.index')
            ->with('success', 'Fee concession rejected successfully.');
    }
}
