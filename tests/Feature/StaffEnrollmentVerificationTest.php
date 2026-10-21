<?php

namespace Tests\Feature;

use App\Models\AcademicSession;
use App\Models\AdmissionApplication;
use App\Models\Course;
use App\Models\CourseFeeStructure;
use App\Models\FeeConcession;
use App\Models\Semester;
use App\Models\StaffAssignment;
use App\Models\StaffPermission;
use App\Models\StaffProfile;
use App\Models\StudentEnrollment;
use App\Models\StudentFeePayment;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Database\QueryException;
use Tests\TestCase;

class StaffEnrollmentVerificationTest extends TestCase
{
    use RefreshDatabase;

    public function test_inactive_enrollment_blocks_payment_verification_without_changing_records(): void
    {
        $setup = $this->makeSetup();
        $enrollment = $this->makeEnrollment($setup, 'inactive');
        $payment = $this->makePayment($setup, $enrollment, 1);

        $response = $this->actingAs($setup['staff'])->post(
            route('staff.fee-payments.verify', $payment->id)
        );

        $response->assertSessionHasErrors('payment');
        $this->assertSame(1, StudentEnrollment::where('admission_application_id', $setup['application']->id)->count());
        $this->assertSame('pending', $payment->fresh()->status);
        $this->assertSame($enrollment->id, $payment->fresh()->student_enrollment_id);
    }

    public function test_active_enrollment_blocks_first_fee_duplicate_creation(): void
    {
        $setup = $this->makeSetup();
        $enrollment = $this->makeEnrollment($setup, 'active');

        $response = $this->actingAs($setup['staff'])->post(
            route('staff.fee-verification.verify-first-fee', $setup['application']->id),
            $this->firstFeePayload()
        );

        $response->assertSessionHasErrors('application');
        $this->assertSame(1, StudentEnrollment::where('admission_application_id', $setup['application']->id)->count());
        $this->assertDatabaseMissing('student_fee_payments', [
            'admission_application_id' => $setup['application']->id,
            'receipt_number' => 'FIRST-001',
        ]);
        $this->assertDatabaseHas('student_enrollments', ['id' => $enrollment->id]);
    }

    public function test_inactive_enrollment_blocks_first_fee_duplicate_creation(): void
    {
        $setup = $this->makeSetup();
        $enrollment = $this->makeEnrollment($setup, 'inactive');

        $response = $this->actingAs($setup['staff'])->post(
            route('staff.fee-verification.verify-first-fee', $setup['application']->id),
            $this->firstFeePayload()
        );

        $response->assertSessionHasErrors('application');
        $this->assertSame(1, StudentEnrollment::where('admission_application_id', $setup['application']->id)->count());
        $this->assertDatabaseHas('student_enrollments', ['id' => $enrollment->id, 'enrollment_status' => 'inactive']);
        $this->assertSame(0, StudentFeePayment::where('admission_application_id', $setup['application']->id)->count());
    }

    public function test_first_fee_verification_creates_only_one_enrollment_and_payment(): void
    {
        $setup = $this->makeSetup();

        $this->actingAs($setup['staff'])->post(
            route('staff.fee-verification.verify-first-fee', $setup['application']->id),
            $this->firstFeePayload()
        )->assertRedirect(route('staff.college-students.index'));

        $this->assertSame(1, StudentEnrollment::where('admission_application_id', $setup['application']->id)->count());
        $this->assertSame(1, StudentFeePayment::where('admission_application_id', $setup['application']->id)->count());

        $this->actingAs($setup['staff'])->post(
            route('staff.fee-verification.verify-first-fee', $setup['application']->id),
            $this->firstFeePayload()
        )->assertSessionHasErrors('application');

        $this->assertSame(1, StudentEnrollment::where('admission_application_id', $setup['application']->id)->count());
        $this->assertSame(1, StudentFeePayment::where('admission_application_id', $setup['application']->id)->count());
    }

    public function test_first_fee_cannot_exceed_the_configured_outstanding_balance(): void
    {
        $setup = $this->makeSetup();
        $payload = $this->firstFeePayload();
        $payload['amount_paid'] = 100001;

        $this->actingAs($setup['staff'])->post(
            route('staff.fee-verification.verify-first-fee', $setup['application']->id),
            $payload
        )->assertSessionHasErrors('amount_paid');

        $this->assertSame(0, StudentEnrollment::where('admission_application_id', $setup['application']->id)->count());
        $this->assertSame(0, StudentFeePayment::where('admission_application_id', $setup['application']->id)->count());
    }

    public function test_first_installment_payment_verification_creates_one_enrollment_and_duplicate_verify_is_rejected(): void
    {
        $setup = $this->makeSetup();
        $payment = $this->makePayment($setup, null, 1);

        $this->actingAs($setup['staff'])->post(
            route('staff.fee-payments.verify', $payment->id)
        )->assertRedirect(route('staff.fee-payments.index'));

        $this->assertSame('verified', $payment->fresh()->status);
        $this->assertSame(1, StudentEnrollment::where('admission_application_id', $setup['application']->id)->count());

        $this->actingAs($setup['staff'])->post(
            route('staff.fee-payments.verify', $payment->id)
        )->assertSessionHasErrors('payment');

        $this->assertSame(1, StudentEnrollment::where('admission_application_id', $setup['application']->id)->count());
        $this->assertSame(1, StudentFeePayment::where('admission_application_id', $setup['application']->id)->count());
    }

    public function test_split_first_installment_payments_can_be_verified_within_the_balance(): void
    {
        $setup = $this->makeSetup();
        $first = $this->makePayment($setup, null, 1);
        $first->update(['amount_paid' => 60000]);
        $second = $this->makePayment($setup, null, 1);
        $second->update(['amount_paid' => 40000]);

        $this->actingAs($setup['staff'])->post(
            route('staff.fee-payments.verify', $first->id)
        )->assertRedirect(route('staff.fee-payments.index'));

        $this->actingAs($setup['staff'])->post(
            route('staff.fee-payments.verify', $second->id)
        )->assertRedirect(route('staff.fee-payments.index'));

        $this->assertSame('verified', $first->fresh()->status);
        $this->assertSame('verified', $second->fresh()->status);
        $this->assertSame(100000.0, (float) StudentFeePayment::query()
            ->where('admission_application_id', $setup['application']->id)
            ->where('status', 'verified')
            ->sum('amount_paid'));
        $this->assertSame(1, StudentEnrollment::where('admission_application_id', $setup['application']->id)->count());
    }

    public function test_two_split_payments_cannot_be_verified_past_the_combined_balance(): void
    {
        $setup = $this->makeSetup();
        $first = $this->makePayment($setup, null, 1);
        $first->update(['amount_paid' => 60000]);
        $second = $this->makePayment($setup, null, 1);
        $second->update(['amount_paid' => 50000]);

        $this->actingAs($setup['staff'])->post(
            route('staff.fee-payments.verify', $first->id)
        )->assertRedirect(route('staff.fee-payments.index'));

        $this->actingAs($setup['staff'])->post(
            route('staff.fee-payments.verify', $second->id)
        )->assertSessionHasErrors('payment');

        $this->assertSame('verified', $first->fresh()->status);
        $this->assertSame('pending', $second->fresh()->status);
        $this->assertSame(60000.0, (float) StudentFeePayment::query()
            ->where('admission_application_id', $setup['application']->id)
            ->where('status', 'verified')
            ->sum('amount_paid'));
    }

    public function test_approved_concession_reduces_balance_available_for_split_payments(): void
    {
        $setup = $this->makeSetup();
        FeeConcession::query()->create([
            'admission_application_id' => $setup['application']->id,
            'semester_id' => $setup['semester']->id,
            'concession_type' => 'scholarship',
            'calculation_type' => 'fixed',
            'requested_value' => 20000,
            'approved_value' => 20000,
            'approved_amount' => 20000,
            'status' => 'approved',
        ]);
        $payment = $this->makePayment($setup, null, 1);
        $payment->update(['amount_paid' => 80001]);

        $this->actingAs($setup['staff'])->post(
            route('staff.fee-payments.verify', $payment->id)
        )->assertSessionHasErrors('payment');

        $this->assertSame('pending', $payment->fresh()->status);
        $this->assertSame(0, StudentEnrollment::where('admission_application_id', $setup['application']->id)->count());
    }

    public function test_concession_approval_respects_already_verified_split_payments(): void
    {
        $setup = $this->makeSetup();
        $payment = $this->makePayment($setup, null, 1);
        $payment->update(['amount_paid' => 60000]);

        $this->actingAs($setup['staff'])->post(
            route('staff.fee-payments.verify', $payment->id)
        )->assertRedirect(route('staff.fee-payments.index'));

        $admin = User::query()->create([
            'name' => 'Test Admin',
            'email' => uniqid('admin-', true) . '@example.test',
            'password' => 'password',
            'role' => 'admin',
        ]);
        $concession = FeeConcession::query()->create([
            'admission_application_id' => $setup['application']->id,
            'semester_id' => $setup['semester']->id,
            'concession_type' => 'scholarship',
            'calculation_type' => 'fixed',
            'requested_value' => 50000,
            'status' => 'pending',
        ]);

        $this->actingAs($admin)->post(
            route('admin.fee-concessions.approve', $concession->id),
            ['approved_value' => 50000]
        )->assertSessionHasErrors('approved_value');

        $this->assertSame('pending', $concession->fresh()->status);
        $this->assertNull($concession->fresh()->approved_amount);
    }

    public function test_rejected_payment_cannot_be_verified(): void
    {
        $setup = $this->makeSetup();
        $payment = $this->makePayment($setup, null, 1);
        $payment->update(['status' => 'rejected']);

        $this->actingAs($setup['staff'])->post(
            route('staff.fee-payments.verify', $payment->id)
        )->assertSessionHasErrors('payment');

        $this->assertSame('rejected', $payment->fresh()->status);
        $this->assertSame(0, StudentEnrollment::where('admission_application_id', $setup['application']->id)->count());
    }

    public function test_subsequent_installment_verification_uses_existing_active_enrollment(): void
    {
        $setup = $this->makeSetup();
        $enrollment = $this->makeEnrollment($setup, 'active');
        $payment = $this->makePayment($setup, $enrollment, 2);

        $this->actingAs($setup['staff'])->post(
            route('staff.fee-payments.verify', $payment->id)
        )->assertRedirect(route('staff.fee-payments.index'));

        $this->assertSame(1, StudentEnrollment::where('admission_application_id', $setup['application']->id)->count());
        $this->assertSame('verified', $payment->fresh()->status);
        $this->assertSame($enrollment->id, $payment->fresh()->student_enrollment_id);
    }

    public function test_enrollment_application_index_rejects_duplicates_and_allows_legacy_nulls(): void
    {
        $setup = $this->makeSetup();

        foreach ([1, 2] as $_) {
            StudentEnrollment::query()->create([
                'user_id' => $setup['student']->id,
                'admission_application_id' => null,
                'course_id' => $setup['course']->id,
                'academic_session_id' => $setup['session']->id,
                'year_number' => 1,
                'current_semester_id' => $setup['semester']->id,
                'enrollment_status' => 'active',
            ]);
        }

        $this->assertSame(2, StudentEnrollment::whereNull('admission_application_id')->count());

        $this->makeEnrollment($setup, 'inactive');

        $this->expectException(QueryException::class);
        $this->makeEnrollment($setup, 'active');
    }

    public function test_fee_verification_permission_is_still_required(): void
    {
        $setup = $this->makeSetup(withPermission: false);
        $payment = $this->makePayment($setup, null, 1);

        $this->actingAs($setup['staff'])->post(
            route('staff.fee-payments.verify', $payment->id)
        )->assertForbidden();

        $this->assertSame('pending', $payment->fresh()->status);
        $this->assertSame(0, StudentEnrollment::where('admission_application_id', $setup['application']->id)->count());
    }

    public function test_staff_without_an_assignment_for_the_payment_scope_is_denied(): void
    {
        $setup = $this->makeSetup();
        $payment = $this->makePayment($setup, null, 1);

        StaffAssignment::query()
            ->where('staff_profile_id', $setup['profile']->id)
            ->update(['is_active' => false]);

        $this->actingAs($setup['staff'])->post(
            route('staff.fee-payments.verify', $payment->id)
        )->assertForbidden();

        $this->assertSame('pending', $payment->fresh()->status);
        $this->assertSame(0, StudentEnrollment::where('admission_application_id', $setup['application']->id)->count());
    }

    private function makeSetup(bool $withPermission = true): array
    {
        $student = User::query()->create([
            'name' => 'Test Student',
            'email' => uniqid('student-', true) . '@example.test',
            'password' => 'password',
            'role' => 'student',
        ]);
        $staff = User::query()->create([
            'name' => 'Test Staff',
            'email' => uniqid('staff-', true) . '@example.test',
            'password' => 'password',
            'role' => 'staff',
        ]);
        $session = AcademicSession::query()->create(['name' => '2026-2027', 'is_active' => true]);
        $course = Course::query()->create(['name' => 'Test Course', 'code' => 'TEST', 'annual_fee' => 100000]);
        $semester = Semester::query()->create(['name' => 'Semester 1', 'semester_number' => 1]);
        $application = AdmissionApplication::query()->create([
            'user_id' => $student->id,
            'academic_session_id' => $session->id,
            'course_id' => $course->id,
            'semester_id' => $semester->id,
            'application_no' => uniqid('APP-'),
            'status' => 'approved',
        ]);
        $profile = StaffProfile::query()->create([
            'user_id' => $staff->id,
            'employee_code' => uniqid('EMP-'),
            'is_active' => true,
        ]);

        StaffAssignment::query()->create([
            'staff_profile_id' => $profile->id,
            'academic_session_id' => $session->id,
            'course_id' => $course->id,
            'semester_id' => $semester->id,
            'role_type' => 'fee_verifier',
            'is_active' => true,
        ]);

        if ($withPermission) {
            StaffPermission::query()->create([
                'staff_profile_id' => $profile->id,
                'permission_key' => 'offline_fee_verification',
                'is_active' => true,
            ]);
        }

        CourseFeeStructure::query()->create([
            'course_id' => $course->id,
            'academic_session_id' => $session->id,
            'annual_fee' => 100000,
            'semester_fee' => 100000,
        ]);

        return compact('student', 'staff', 'session', 'course', 'semester', 'application', 'profile');
    }

    private function makeEnrollment(array $setup, string $status): StudentEnrollment
    {
        return StudentEnrollment::query()->create([
            'user_id' => $setup['student']->id,
            'admission_application_id' => $setup['application']->id,
            'course_id' => $setup['course']->id,
            'academic_session_id' => $setup['session']->id,
            'year_number' => 1,
            'current_semester_id' => $setup['semester']->id,
            'enrollment_status' => $status,
        ]);
    }

    private function makePayment(array $setup, ?StudentEnrollment $enrollment, int $installment): StudentFeePayment
    {
        return StudentFeePayment::query()->create([
            'admission_application_id' => $setup['application']->id,
            'student_enrollment_id' => $enrollment?->id,
            'semester_id' => $setup['semester']->id,
            'installment_number' => $installment,
            'amount_paid' => 10000,
            'payment_mode' => 'cash',
            'receipt_number' => 'R-' . uniqid(),
            'payment_date' => now()->toDateString(),
            'status' => 'pending',
        ]);
    }

    private function firstFeePayload(): array
    {
        return [
            'amount_paid' => 10000,
            'payment_mode' => 'cash',
            'receipt_number' => 'FIRST-001',
            'payment_date' => now()->toDateString(),
        ];
    }
}
