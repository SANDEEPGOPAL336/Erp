<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use App\Models\AdmissionApplication;
use App\Models\CourseFeeComponent;
use App\Models\CourseFeeStructure;
use App\Models\FeeConcession;
use App\Models\Semester;
use App\Models\StudentEnrollment;
use App\Models\StudentFeePayment;
use App\Services\AdmissionFeeBalance;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class StaffFeePaymentsController extends Controller
{
    public function index(Request $request)
    {
        $profile = $this->activeStaffProfile($request);
        $assignments = $profile->assignments()
            ->where('is_active', true)
            ->with(['course', 'session', 'semester'])
            ->get();

        $search = trim((string) $request->input('search', ''));
        $query = StudentFeePayment::query()
            ->with([
                'admissionApplication.student.studentProfile',
                'admissionApplication.course',
                'admissionApplication.session',
                'admissionApplication.semester',
                'studentEnrollment.course',
                'semester',
            ])
            ->where('status', 'pending');

        if ($assignments->isEmpty()) {
            $query->whereRaw('1 = 0');
        } else {
            $query->where(function (Builder $outer) use ($assignments) {
                foreach ($assignments as $assignment) {
                    $outer->orWhere(function (Builder $scoped) use ($assignment) {
                        $scoped->whereHas('admissionApplication', function (Builder $application) use ($assignment) {
                            $application->where('status', 'approved')
                                ->where('course_id', $assignment->course_id)
                                ->where('academic_session_id', $assignment->academic_session_id);
                        });

                        if ($assignment->semester_id !== null) {
                            $scoped->where(function (Builder $paymentSemester) use ($assignment) {
                                $paymentSemester->where('semester_id', $assignment->semester_id)
                                    ->orWhere(function (Builder $legacyPayment) use ($assignment) {
                                        $legacyPayment->whereNull('semester_id')
                                            ->whereHas('admissionApplication', function (Builder $application) use ($assignment) {
                                                $application->where('semester_id', $assignment->semester_id);
                                            });
                                    })
                                    ->orWhereHas('studentEnrollment', function (Builder $enrollment) use ($assignment) {
                                        $enrollment->where('enrollment_status', 'active')
                                            ->where('course_id', $assignment->course_id)
                                            ->where('academic_session_id', $assignment->academic_session_id)
                                            ->where('current_semester_id', $assignment->semester_id);
                                    });
                            });
                        }
                    });
                }
            });
        }

        if ($search !== '') {
            $query->whereHas('admissionApplication', function (Builder $application) use ($search) {
                $application->where('application_no', 'like', '%' . $search . '%')
                    ->orWhereHas('student', function (Builder $student) use ($search) {
                        $student->where('name', 'like', '%' . $search . '%')
                            ->orWhere('email', 'like', '%' . $search . '%')
                            ->orWhere('phone', 'like', '%' . $search . '%');
                    });
            });
        }

        $pendingCount = (clone $query)->count();
        $pendingAmount = (float) (clone $query)->sum('amount_paid');
        $payments = $query->orderBy('payment_date')->orderBy('id')
            ->paginate(20)->withQueryString();

        $payments->getCollection()->transform(function (StudentFeePayment $payment) {
            $application = $payment->admissionApplication;
            $semesterId = $payment->semester_id ?? $payment->studentEnrollment?->current_semester_id ?? $application?->semester_id;
            $feeTotal = $this->configuredFeeTotal($application, $semesterId);
            $verified = $application && $semesterId
                ? $this->verifiedPaymentTotalForSemester($application, (int) $semesterId)
                : 0.0;
            $concessions = $application && $semesterId
                ? (float) FeeConcession::query()
                    ->where('admission_application_id', $application->id)
                    ->where('semester_id', $semesterId)
                    ->where('status', 'approved')
                    ->whereNotNull('approved_amount')
                    ->sum('approved_amount')
                : 0.0;

            $payment->setAttribute('fee_configured_total', $feeTotal);
            $payment->setAttribute('fee_verified_total', round($verified, 2));
            $payment->setAttribute('fee_concession_total', round($concessions, 2));
            $payment->setAttribute(
                'fee_outstanding_balance',
                $feeTotal === null ? null : round(max(0, $feeTotal - $verified - $concessions), 2)
            );

            return $payment;
        });

        return view('staff.fee-payments.index', compact(
            'payments',
            'pendingCount',
            'pendingAmount',
            'search'
        ));
    }

    public function verify(Request $request, int $id)
    {
        $profile = $this->activeStaffProfile($request);
        $data = $request->validate([
            'verification_remarks' => ['nullable', 'string', 'max:1000'],
        ]);

        // Preflight without relations or a transaction snapshot, then repeat
        // the pending check against the locked row after the application lock.
        $paymentReference = StudentFeePayment::query()
            ->whereKey($id)
            ->firstOrFail(['id', 'admission_application_id', 'status']);

        if ($paymentReference->status !== 'pending') {
            throw ValidationException::withMessages([
                'payment' => 'Only pending payments can be verified. Refresh the page and try again.',
            ]);
        }

        // The application row is the serialization mutex and must be locked
        // before any transaction snapshot is read.
        $applicationId = $paymentReference->admission_application_id;

        if (!$applicationId) {
            DB::transaction(function () use ($id) {
                $payment = StudentFeePayment::query()
                    ->whereKey($id)
                    ->lockForUpdate()
                    ->firstOrFail();

                if ($payment->status !== 'pending') {
                    throw ValidationException::withMessages([
                        'payment' => 'Only pending payments can be verified. Refresh the page and try again.',
                    ]);
                }

                throw ValidationException::withMessages([
                    'payment' => 'The linked admission application must be approved before this payment can be verified.',
                ]);
            });
        }

        DB::transaction(function () use ($profile, $id, $data, $request, $applicationId) {
            // All fee-state writers lock application first, then payment.
            $application = AdmissionApplication::query()
                ->whereKey($applicationId)
                ->lockForUpdate()
                ->firstOrFail();

            $payment = StudentFeePayment::query()
                ->whereKey($id)
                ->lockForUpdate()
                ->firstOrFail();

            if ((int) $payment->admission_application_id !== (int) $application->id) {
                throw ValidationException::withMessages([
                    'payment' => 'The payment application changed while it was being reviewed. Refresh and try again.',
                ]);
            }

            if ($payment->status !== 'pending') {
                throw ValidationException::withMessages([
                    'payment' => 'Only pending payments can be verified. Refresh the page and try again.',
                ]);
            }

            // Relation reads happen after the application lock. Balance reads
            // below use locking/current reads as well, so an older InnoDB
            // REPEATABLE READ snapshot cannot hide a committed partial payment.
            $application->load(['course', 'session', 'semester']);

            if ($application->status !== 'approved') {
                throw ValidationException::withMessages([
                    'payment' => 'The linked admission application must be approved before this payment can be verified.',
                ]);
            }

            $enrollment = StudentEnrollment::query()
                ->where('admission_application_id', $application->id)
                ->lockForUpdate()
                ->first();

            if ($enrollment && $enrollment->enrollment_status !== 'active') {
                throw ValidationException::withMessages([
                    'payment' => 'An enrollment already exists for this admission application and is inactive. No new enrollment will be created; contact an administrator to review the existing enrollment.',
                ]);
            }

            $semesterId = $payment->semester_id
                ?? $enrollment?->current_semester_id
                ?? $application->semester_id;
            if (!$semesterId
                || ($enrollment && (int) $enrollment->current_semester_id !== (int) $semesterId)
                || (!$enrollment && $application->semester_id && (int) $application->semester_id !== (int) $semesterId)) {
                throw ValidationException::withMessages([
                    'payment' => 'The payment semester does not match the application or active enrollment. Correct the semester link before verification.',
                ]);
            }

            if (!$this->staffCanAccessPayment($profile, $application, (int) $semesterId, $enrollment)) {
                abort(403, 'You are not assigned to verify payments for this application/enrollment semester.');
            }

            $mode = strtolower(trim((string) $payment->payment_mode));
            if (in_array($mode, ['online', 'razorpay', 'cashfree', 'gateway'], true)) {
                throw ValidationException::withMessages([
                    'payment' => 'Gateway-type payments cannot be manually verified. Integrate and verify the gateway server-side first.',
                ]);
            }

            $balance = app(AdmissionFeeBalance::class);
            $feeTotal = $balance->configuredFeeTotal($application, (int) $semesterId);
            if ($feeTotal === null || $feeTotal <= 0) {
                throw ValidationException::withMessages([
                    'payment' => 'No semester fee is configured for this course and academic session. Ask an administrator to configure the fee before verifying the payment.',
                ]);
            }

            $verifiedBefore = $balance->verifiedPaymentTotal(
                $application,
                (int) $semesterId
            );

            $approvedConcessions = $balance->approvedConcessionTotal(
                $application->id,
                (int) $semesterId
            );

            $balanceBeforeThisPayment = max(0, $feeTotal - $verifiedBefore - $approvedConcessions);
            if ((float) $payment->amount_paid > $balanceBeforeThisPayment + 0.0001) {
                throw ValidationException::withMessages([
                    'payment' => sprintf(
                        'This payment (₹%.2f) exceeds the current outstanding balance (₹%.2f). Review the fee account before verifying it.',
                        (float) $payment->amount_paid,
                        $balanceBeforeThisPayment
                    ),
                ]);
            }

            if (!$enrollment) {
                if ((int) $payment->installment_number !== 1) {
                    throw ValidationException::withMessages([
                        'payment' => 'The first installment must be verified before a later installment can be verified for an unenrolled student.',
                    ]);
                }

                $alreadyVerifiedFirst = StudentFeePayment::query()
                    ->where('admission_application_id', $application->id)
                    ->where('installment_number', 1)
                    ->where('status', 'verified')
                    ->whereKeyNot($payment->id)
                    ->orderBy('id')
                    ->lockForUpdate()
                    ->first(['id']);

                if ($alreadyVerifiedFirst !== null) {
                    throw ValidationException::withMessages([
                        'payment' => 'A first-installment payment is already verified. Check the existing enrollment instead of creating another one.',
                    ]);
                }

                $semesterNumber = (int) ($application->semester?->semester_number ?? 0);
                $yearNumber = $semesterNumber > 0
                    ? max(1, min(8, (int) ceil($semesterNumber / 2)))
                    : 1;

                $enrollment = StudentEnrollment::query()->create([
                    'user_id' => $application->user_id,
                    'admission_application_id' => $application->id,
                    'course_id' => $application->course_id,
                    'academic_session_id' => $application->academic_session_id,
                    'year_number' => $yearNumber,
                    'current_semester_id' => $semesterId,
                    'enrollment_status' => 'active',
                    'enrollment_date' => now()->toDateString(),
                ]);

                $sessionYear = $application->session?->start_date
                    ? $application->session->start_date->format('Y')
                    : now()->format('Y');
                $courseCode = strtoupper(preg_replace(
                    '/[^A-Z0-9]+/i',
                    '',
                    (string) ($application->course?->code ?? 'STU')
                ));
                $serial = str_pad((string) $enrollment->id, 5, '0', STR_PAD_LEFT);

                $enrollment->update([
                    'college_number' => 'MG/' . $sessionYear . '/' . $serial,
                    'roll_number' => $courseCode . '/' . $yearNumber . '/' . $serial,
                ]);
            }

            $payment->semester_id = $semesterId;
            $payment->student_enrollment_id = $enrollment->id;
            $payment->status = 'verified';
            $payment->verified_by = $request->user()->id;
            $payment->verified_at = now();
            $payment->payment_date = $payment->payment_date ?: now()->toDateString();

            if (!empty($data['verification_remarks'])) {
                $existing = trim((string) $payment->remarks);
                $payment->remarks = trim($existing . ($existing !== '' ? "\n" : '') . 'Verification note: ' . $data['verification_remarks']);
            }

            $payment->save();
        }, 3);

        return redirect()->route('staff.fee-payments.index')
            ->with('success', 'Payment verified. The existing payment record was updated; no duplicate payment was created.');
    }

    public function reject(Request $request, int $id)
    {
        $profile = $this->activeStaffProfile($request);
        $data = $request->validate([
            'rejection_reason' => ['required', 'string', 'min:3', 'max:1000'],
        ]);

        $applicationId = StudentFeePayment::query()
            ->whereKey($id)
            ->value('admission_application_id');

        DB::transaction(function () use ($profile, $id, $data, $applicationId) {
            $application = $applicationId
                ? AdmissionApplication::query()
                    ->whereKey($applicationId)
                    ->lockForUpdate()
                    ->first()
                : null;

            $payment = StudentFeePayment::query()
                ->whereKey($id)
                ->lockForUpdate()
                ->firstOrFail();

            if ($payment->status !== 'pending') {
                throw ValidationException::withMessages([
                    'payment' => 'Only pending payments can be rejected. Refresh the page and try again.',
                ]);
            }

            if (!$application
                || (int) $payment->admission_application_id !== (int) $application->id
                || $application->status !== 'approved') {
                abort(403, 'Only payments linked to an approved admission application can be reviewed.');
            }

            $application->load(['course', 'session', 'semester']);
            $enrollment = StudentEnrollment::query()
                ->where('admission_application_id', $application->id)
                ->where('enrollment_status', 'active')
                ->lockForUpdate()
                ->first();
            $semesterId = (int) ($payment->semester_id ?? $enrollment?->current_semester_id ?? $application->semester_id ?? 0);
            if (!$semesterId || !$this->staffCanAccessPayment($profile, $application, $semesterId, $enrollment)) {
                abort(403, 'You are not assigned to review this payment for its semester.');
            }
            $oldRemarks = trim((string) $payment->remarks);
            $reviewNote = 'Rejected by staff on ' . now()->format('d-m-Y H:i') . ': ' . trim($data['rejection_reason']);
            $payment->status = 'rejected';
            $payment->remarks = trim($oldRemarks . ($oldRemarks !== '' ? "\n" : '') . $reviewNote);
            $payment->save();
        }, 3);

        return redirect()->route('staff.fee-payments.index')
            ->with('success', 'Payment rejected with the reason saved in its payment record.');
    }

    private function activeStaffProfile(Request $request)
    {
        $user = $request->user();
        abort_unless($user && $user->role === 'staff', 403);

        $profile = $user->staffProfile;
        abort_unless($profile && $profile->is_active, 403);

        return $profile;
    }

    private function staffCanAccessPayment($profile, AdmissionApplication $application, int $semesterId, ?StudentEnrollment $enrollment): bool
    {
        $assignments = $profile->assignments()
            ->where('is_active', true)
            ->get(['course_id', 'academic_session_id', 'semester_id']);

        foreach ($assignments as $assignment) {
            if ((int) $assignment->course_id !== (int) $application->course_id) {
                continue;
            }
            if ((int) $assignment->academic_session_id !== (int) $application->academic_session_id) {
                continue;
            }
            if ($assignment->semester_id !== null
                && (int) $assignment->semester_id !== $semesterId) {
                continue;
            }
            if ($enrollment) {
                if ((int) $enrollment->current_semester_id !== $semesterId) {
                    continue;
                }
            } elseif ($application->semester_id !== null
                && (int) $application->semester_id !== $semesterId) {
                continue;
            }

            return true;
        }

        return false;
    }

    /**
     * Sum verified payments for a semester, including legacy records whose
     * semester_id is NULL when their enrollment or admission application
     * identifies the semester unambiguously.
     */
    private function verifiedPaymentTotalForSemester(
        AdmissionApplication $application,
        int $semesterId
    ): float {
        return round((float) StudentFeePayment::query()
            ->where('admission_application_id', $application->id)
            ->where('status', 'verified')
            ->where(function (Builder $payments) use ($semesterId) {
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
            })
            ->sum('amount_paid'), 2);
    }

    private function configuredFeeTotal(?AdmissionApplication $application, ?int $semesterId): ?float
    {
        if (!$application || !$semesterId) {
            return null;
        }

        $components = CourseFeeComponent::query()
            ->where('course_id', $application->course_id)
            ->where('academic_session_id', $application->academic_session_id)
            ->where('is_active', true)
            ->where(function (Builder $query) use ($semesterId) {
                $query->whereNull('semester_id')->orWhere('semester_id', $semesterId);
            })
            ->sum('amount');

        if ((float) $components > 0) {
            return round((float) $components, 2);
        }

        $legacy = CourseFeeStructure::query()
            ->where('course_id', $application->course_id)
            ->where('academic_session_id', $application->academic_session_id)
            ->value('semester_fee');

        return $legacy === null ? null : round((float) $legacy, 2);
    }
}
