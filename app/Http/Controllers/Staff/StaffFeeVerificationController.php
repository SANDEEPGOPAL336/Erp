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

class StaffFeeVerificationController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();

        abort_unless($user && $user->role === 'staff', 403);

        $staffProfile = $user->staffProfile;

        abort_unless(
            $staffProfile && $staffProfile->is_active,
            403
        );

        $assignments = $staffProfile->assignments()
            ->with(['course', 'session', 'semester'])
            ->where('is_active', true)
            ->get();

        $courseOptions = $assignments->pluck('course')
            ->filter()
            ->unique('id')
            ->sortBy('name')
            ->values();

        $sessionOptions = $assignments->pluck('session')
            ->filter()
            ->unique('id')
            ->sortByDesc('start_date')
            ->values();

        $semesterOptions = $assignments->contains(
            fn ($assignment) => $assignment->semester_id === null
        )
            ? Semester::query()
                ->where('is_active', true)
                ->orderBy('semester_number')
                ->get()
            : $assignments->pluck('semester')
                ->filter()
                ->unique('id')
                ->sortBy('semester_number')
                ->values();

        $query = $this->accessibleApprovedApplicationsQuery(
            $assignments
        );

        $selectedSession = $request->filled('session_id')
            ? (int) $request->session_id
            : null;

        $selectedCourse = $request->filled('course_id')
            ? (int) $request->course_id
            : null;

        $selectedSemester = $request->filled('semester_id')
            ? (int) $request->semester_id
            : null;

        $search = trim((string) $request->input('search', ''));

        $assignmentCourseIds = $assignments
            ->pluck('course_id')
            ->filter()
            ->unique();

        $assignmentSessionIds = $assignments
            ->pluck('academic_session_id')
            ->filter()
            ->unique();

        if (
            $selectedSession &&
            !$assignmentSessionIds->contains($selectedSession)
        ) {
            $selectedSession = null;
        }

        if (
            $selectedCourse &&
            !$assignmentCourseIds->contains($selectedCourse)
        ) {
            $selectedCourse = null;
        }

        if (
            $selectedSemester &&
            !$semesterOptions->pluck('id')->contains($selectedSemester)
        ) {
            $selectedSemester = null;
        }

        if ($selectedSession) {
            $query->where(
                'academic_session_id',
                $selectedSession
            );
        }

        if ($selectedCourse) {
            $query->where('course_id', $selectedCourse);
        }

        if ($selectedSemester) {
            $query->where('semester_id', $selectedSemester);
        }

        if ($search !== '') {
            $query->where(function (Builder $q) use ($search) {
                $q->where(
                    'application_no',
                    'like',
                    '%' . $search . '%'
                )->orWhereHas(
                    'student',
                    function (Builder $studentQuery) use ($search) {
                        $studentQuery
                            ->where('name', 'like', '%' . $search . '%')
                            ->orWhere('phone', 'like', '%' . $search . '%')
                            ->orWhere('email', 'like', '%' . $search . '%');
                    }
                );
            });
        }

        $pendingFirstFee = (clone $query)->count();

        $applications = $query
            ->with([
                'student.studentProfile',
                'course',
                'session',
                'semester',
            ])
            ->orderByDesc('reviewed_at')
            ->orderByDesc('id')
            ->paginate(20)
            ->withQueryString();

        /*
         * Attach the fee summary to each application on this page.
         *
         * Applicable components:
         * - active components for this application's semester
         * - active general components with NULL semester_id
         *
         * If no matching components exist, fall back to the
         * existing legacy semester fee structure.
         */
        $applications->getCollection()->transform(
            function (AdmissionApplication $application) {
                $components = CourseFeeComponent::query()
                    ->with('feeComponentType')
                    ->where('course_id', $application->course_id)
                    ->where(
                        'academic_session_id',
                        $application->academic_session_id
                    )
                    ->where('is_active', true)
                    ->where(function (Builder $componentQuery) use ($application) {
                        $componentQuery->whereNull('semester_id');

                        if ($application->semester_id !== null) {
                            $componentQuery->orWhere(
                                'semester_id',
                                $application->semester_id
                            );
                        }
                    })
                    ->orderBy('fee_component_type_id')
                    ->get();

                $feeTotal = (float) $components->sum(
                    fn ($component) => (float) $component->amount
                );

                $feeSource = $components->isNotEmpty()
                    ? 'components'
                    : 'none';

                if ($components->isEmpty()) {
                    $legacyStructure = CourseFeeStructure::query()
                        ->where('course_id', $application->course_id)
                        ->where(
                            'academic_session_id',
                            $application->academic_session_id
                        )
                        ->first();

                    if ($legacyStructure) {
                        $feeTotal = (float) $legacyStructure->semester_fee;
                        $feeSource = 'legacy';
                    }
                }

                /*
                 * Include only verified payments for this semester.
                 * NULL semester_id is included for legacy payments
                 * whose semester was never stored.
                 */
                $verifiedPaidQuery = StudentFeePayment::query()
                    ->where(
                        'admission_application_id',
                        $application->id
                    )
                    ->where('status', 'verified');

                $verifiedPaidQuery->where(
                    function (Builder $paymentQuery) use ($application) {
                        if ($application->semester_id !== null) {
                            $paymentQuery
                                ->where(
                                    'semester_id',
                                    $application->semester_id
                                )
                                ->orWhereNull('semester_id');
                        } else {
                            $paymentQuery->whereNull('semester_id');
                        }
                    }
                );

                $verifiedPaid = (float) $verifiedPaidQuery
                    ->sum('amount_paid');

                $application->setAttribute(
                    'fee_components_for_verification',
                    $components
                );

                $application->setAttribute(
                    'configured_fee_total',
                    round($feeTotal, 2)
                );

                $application->setAttribute(
                    'verified_fee_total',
                    round($verifiedPaid, 2)
                );

                $application->setAttribute(
                    'fee_balance_before_payment',
                    round(max(0, $feeTotal - $verifiedPaid), 2)
                );

                $application->setAttribute(
                    'fee_total_source',
                    $feeSource
                );

                return $application;
            }
        );

        return view('staff.fee-verification.index', [
            'staffProfile' => $staffProfile,
            'assignments' => $assignments,
            'applications' => $applications,
            'courseOptions' => $courseOptions,
            'sessionOptions' => $sessionOptions,
            'semesterOptions' => $semesterOptions,
            'pendingFirstFee' => $pendingFirstFee,
            'selectedSession' => $selectedSession,
            'selectedCourse' => $selectedCourse,
            'selectedSemester' => $selectedSemester,
            'search' => $search,
        ]);
    }

    public function verifyFirstFee(Request $request, int $id)
    {
        $user = $request->user();

        abort_unless($user && $user->role === 'staff', 403);

        $staffProfile = $user->staffProfile;

        abort_unless(
            $staffProfile && $staffProfile->is_active,
            403
        );

        $data = $request->validate([
            'amount_paid' => [
                'required',
                'numeric',
                'min:0.01',
                'max:9999999999.99',
            ],
            'payment_mode' => [
                'required',
                'string',
                'max:30',
            ],
            'receipt_number' => [
                'required',
                'string',
                'max:100',
            ],
            'payment_date' => [
                'required',
                'date',
            ],
            'remarks' => [
                'nullable',
                'string',
                'max:2000',
            ],
        ]);

        $assignments = $staffProfile->assignments()
            ->where('is_active', true)
            ->with(['course', 'session', 'semester'])
            ->get();

        $application = $this->accessibleApprovedApplicationsQuery(
            $assignments,
            includeAlreadyProcessed: true
        )
            ->with([
                'student.studentProfile',
                'course',
                'session',
                'semester',
            ])
            ->whereKey($id)
            ->firstOrFail();

        DB::transaction(function () use (
            $application,
            $data,
            $user
        ) {
            $application = AdmissionApplication::query()
                ->with(['course', 'session', 'semester'])
                ->whereKey($application->id)
                ->lockForUpdate()
                ->firstOrFail();

            if ($application->status !== 'approved') {
                throw ValidationException::withMessages([
                    'application' => 'Only approved admission applications can have their first fee verified.',
                ]);
            }

            // Lock installment-one rows before enrollment, matching the
            // application -> payment -> enrollment order used by payment review.
            $firstInstallmentPayments = StudentFeePayment::query()
                ->where(
                    'admission_application_id',
                    $application->id
                )
                ->where('installment_number', 1)
                ->orderBy('id')
                ->lockForUpdate()
                ->get(['id', 'status']);

            if ($firstInstallmentPayments->contains('status', 'verified')) {
                throw ValidationException::withMessages([
                    'application' => 'A first-installment payment is already verified for this application. No additional enrollment or payment was created.',
                ]);
            }

            $existingEnrollment = StudentEnrollment::query()
                ->where('admission_application_id', $application->id)
                ->lockForUpdate()
                ->first();

            if ($existingEnrollment) {
                throw ValidationException::withMessages([
                    'application' => 'An enrollment already exists for this admission application. No additional enrollment was created; review the existing enrollment.',
                ]);
            }

            $balance = app(AdmissionFeeBalance::class);
            $feeTotal = $balance->configuredFeeTotal(
                $application,
                (int) $application->semester_id
            );
            if ($feeTotal === null || $feeTotal <= 0) {
                throw ValidationException::withMessages([
                    'amount_paid' => 'No semester fee is configured for this course and academic session. Ask an administrator to configure the fee before verifying the payment.',
                ]);
            }

            $verifiedBefore = $balance->verifiedPaymentTotal(
                $application,
                (int) $application->semester_id
            );
            $approvedConcessions = $balance->approvedConcessionTotal(
                $application->id,
                (int) $application->semester_id
            );

            $balanceBeforeThisPayment = max(0, $feeTotal - $verifiedBefore - $approvedConcessions);
            if ((float) $data['amount_paid'] > $balanceBeforeThisPayment + 0.0001) {
                throw ValidationException::withMessages([
                    'amount_paid' => sprintf(
                        'This payment (₹%.2f) exceeds the current outstanding balance (₹%.2f). Review the fee account before verifying it.',
                        (float) $data['amount_paid'],
                        $balanceBeforeThisPayment
                    ),
                ]);
            }

            $enrollment = StudentEnrollment::query()->create([
                'user_id' => $application->user_id,
                'admission_application_id' => $application->id,
                'course_id' => $application->course_id,
                'academic_session_id' => $application->academic_session_id,
                'year_number' => $this->yearNumber($application),
                'current_semester_id' => $application->semester_id,
                'enrollment_status' => 'active',
                'enrollment_date' => now()->toDateString(),
            ]);

            $sessionYear = $application->session?->start_date
                ? $application->session->start_date->format('Y')
                : now()->format('Y');

            $courseCode = strtoupper(
                preg_replace(
                    '/[^A-Z0-9]+/i',
                    '',
                    (string) ($application->course?->code ?? 'STU')
                )
            );

            $serial = str_pad(
                (string) $enrollment->id,
                5,
                '0',
                STR_PAD_LEFT
            );

            $enrollment->update([
                'college_number' => 'MG/' . $sessionYear . '/' . $serial,
                'roll_number' => $courseCode . '/'
                    . $enrollment->year_number . '/' . $serial,
            ]);

            StudentFeePayment::query()->create([
                'admission_application_id' => $application->id,
                'student_enrollment_id' => $enrollment->id,

                // semester_id references semesters.id.
                'semester_id' => $application->semester_id,

                'installment_number' => 1,
                'amount_paid' => $data['amount_paid'],
                'payment_mode' => $data['payment_mode'],
                'receipt_number' => $data['receipt_number'],
                'payment_date' => $data['payment_date'],
                'status' => 'verified',
                'verified_by' => $user->id,
                'verified_at' => now(),
                'remarks' => $data['remarks'] ?? null,
            ]);
        }, 3);

        return redirect()
            ->route('staff.college-students.index')
            ->with(
                'success',
                'First fee verified successfully. College Number and Roll Number have been assigned.'
            );
    }

    private function accessibleApprovedApplicationsQuery(
        $assignments,
        bool $includeAlreadyProcessed = false
    ): Builder {
        $query = AdmissionApplication::query()
            ->where('status', 'approved');

        if (!$includeAlreadyProcessed) {
            $query
            ->whereNotExists(function ($subQuery) {
                $subQuery->selectRaw('1')
                    ->from('student_enrollments')
                    ->whereColumn(
                        'student_enrollments.admission_application_id',
                        'admission_applications.id'
                    );
            })
            ->whereNotExists(function ($subQuery) {
                $subQuery->selectRaw('1')
                    ->from('student_fee_payments')
                    ->whereColumn(
                        'student_fee_payments.admission_application_id',
                        'admission_applications.id'
                    )
                    ->where(
                        'student_fee_payments.installment_number',
                        1
                    )
                    ->where('student_fee_payments.status', 'verified');
            });
        }

        if ($assignments->isEmpty()) {
            return $query->whereRaw('1 = 0');
        }

        $query->where(function (Builder $scope) use ($assignments) {
            foreach ($assignments as $assignment) {
                $scope->orWhere(
                    function (Builder $assignmentQuery) use ($assignment) {
                        $assignmentQuery
                            ->where('course_id', $assignment->course_id)
                            ->where(
                                'academic_session_id',
                                $assignment->academic_session_id
                            );

                        if ($assignment->semester_id !== null) {
                            $assignmentQuery->where(
                                function (Builder $semesterQuery) use ($assignment) {
                                    $semesterQuery
                                        ->whereNull('semester_id')
                                        ->orWhere(
                                            'semester_id',
                                            $assignment->semester_id
                                        );
                                }
                            );
                        }
                    }
                );
            }
        });

        return $query;
    }

    private function yearNumber($application): int
    {
        $semesterNumber = (int) (
            $application->semester?->semester_number ?? 0
        );

        return $semesterNumber > 0
            ? max(1, min(8, (int) ceil($semesterNumber / 2)))
            : 1;
    }

}
