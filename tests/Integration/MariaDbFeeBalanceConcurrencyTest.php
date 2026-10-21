<?php

namespace Tests\Integration;

use App\Http\Controllers\Staff\StaffFeePaymentsController;
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
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;
use Symfony\Component\Process\Process;
use Tests\TestCase;

class MariaDbFeeBalanceConcurrencyTest extends TestCase
{
    private const DATABASE = 'college_erp_concurrency_test';

    public function test_parallel_payments_of_600_cannot_exceed_a_fee_of_1000(): void
    {
        $setup = $this->makeSetup(1000);
        $first = $this->makePayment($setup, null, 1, 600);
        $second = $this->makePayment($setup, null, 1, 600);

        $results = $this->runOverlappingWorkers($setup['application']->id, [
            ['verify_payment', $setup['staff']->id, $first->id, []],
            ['verify_payment', $setup['staff']->id, $second->id, []],
        ]);

        $statuses = [$first->fresh()->status, $second->fresh()->status];
        $this->assertCount(1, array_filter($statuses, fn (string $status) => $status === 'verified'));
        $this->assertCount(1, array_filter($statuses, fn (string $status) => $status === 'pending'));
        $this->assertSame(1, count(array_filter($results, fn (array $result) => $result['outcome'] === 'accepted')));
        $this->assertSame(1, count(array_filter($results, fn (array $result) => $result['outcome'] === 'rejected')));
        $this->assertSame(302, collect($results)->firstWhere('outcome', 'accepted')['status']);
        $this->assertSame(422, collect($results)->firstWhere('outcome', 'rejected')['status']);

        $acceptedTotal = (float) StudentFeePayment::query()
            ->where('admission_application_id', $setup['application']->id)
            ->where('status', 'verified')
            ->sum('amount_paid');
        $this->assertLessThanOrEqual(1000.0, $acceptedTotal);
        $this->assertSame(600.0, $acceptedTotal);
        $this->assertSame(1, StudentEnrollment::query()
            ->where('admission_application_id', $setup['application']->id)
            ->count());
    }

    public function test_parallel_payment_and_concession_approval_cannot_exceed_fee(): void
    {
        $setup = $this->makeSetup(1000);
        $payment = $this->makePayment($setup, null, 1, 600);
        $admin = $this->makeAdmin();
        $concession = FeeConcession::query()->create([
            'admission_application_id' => $setup['application']->id,
            'semester_id' => $setup['semester']->id,
            'concession_type' => 'scholarship',
            'calculation_type' => 'fixed',
            'requested_value' => 600,
            'status' => 'pending',
        ]);

        $results = $this->runOverlappingWorkers($setup['application']->id, [
            ['verify_payment', $setup['staff']->id, $payment->id, []],
            ['approve_concession', $admin->id, $concession->id, ['approved_value' => 600]],
        ]);

        $payment->refresh();
        $concession->refresh();
        $accepted = (float) StudentFeePayment::query()
            ->where('admission_application_id', $setup['application']->id)
            ->where('status', 'verified')
            ->sum('amount_paid');
        $approved = (float) FeeConcession::query()
            ->where('admission_application_id', $setup['application']->id)
            ->where('semester_id', $setup['semester']->id)
            ->where('status', 'approved')
            ->sum('approved_amount');

        $this->assertLessThanOrEqual(1000.0, $accepted + $approved);
        $this->assertSame(1, count(array_filter($results, fn (array $result) => $result['outcome'] === 'accepted')));
        $this->assertSame(1, count(array_filter($results, fn (array $result) => $result['outcome'] === 'rejected')));
        $this->assertSame(302, collect($results)->firstWhere('outcome', 'accepted')['status']);
        $this->assertSame(422, collect($results)->firstWhere('outcome', 'rejected')['status']);
        $this->assertContains($payment->status, ['pending', 'verified']);
        $this->assertContains($concession->status, ['pending', 'approved']);
        $this->assertSame(
            $payment->status === 'verified' ? 600.0 : 0.0,
            $accepted
        );
        $this->assertSame(
            $concession->status === 'approved' ? 600.0 : 0.0,
            $approved
        );
        $this->assertTrue(
            ($payment->status === 'verified' && $concession->status === 'pending')
            || ($payment->status === 'pending' && $concession->status === 'approved')
        );
    }

    public function test_split_payments_duplicate_submission_inactive_enrollment_and_later_installment(): void
    {
        $splitSetup = $this->makeSetup(1000);
        $first = $this->makePayment($splitSetup, null, 1, 400);
        $second = $this->makePayment($splitSetup, null, 1, 400);

        $this->assertSame('accepted', $this->runWorker(
            'verify_payment', $splitSetup['staff']->id, $first->id
        )['outcome']);
        $this->assertSame('accepted', $this->runWorker(
            'verify_payment', $splitSetup['staff']->id, $second->id
        )['outcome']);
        $this->assertSame(800.0, (float) StudentFeePayment::query()
            ->where('admission_application_id', $splitSetup['application']->id)
            ->where('status', 'verified')
            ->sum('amount_paid'));
        $this->assertSame(1, StudentEnrollment::query()
            ->where('admission_application_id', $splitSetup['application']->id)
            ->count());

        $duplicate = $this->runWorker('verify_payment', $splitSetup['staff']->id, $first->id);
        $this->assertSame('rejected', $duplicate['outcome']);
        $this->assertSame(422, $duplicate['status']);
        $this->assertSame(2, StudentFeePayment::query()
            ->where('admission_application_id', $splitSetup['application']->id)
            ->count());

        $inactiveSetup = $this->makeSetup(1000);
        $inactive = $this->makeEnrollment($inactiveSetup, 'inactive');
        $inactivePayment = $this->makePayment($inactiveSetup, $inactive, 1, 100);
        $inactiveResult = $this->runWorker(
            'verify_payment', $inactiveSetup['staff']->id, $inactivePayment->id
        );
        $this->assertSame('rejected', $inactiveResult['outcome']);
        $this->assertSame(422, $inactiveResult['status']);
        $this->assertSame('pending', $inactivePayment->fresh()->status);
        $this->assertSame(1, StudentEnrollment::query()
            ->where('admission_application_id', $inactiveSetup['application']->id)
            ->count());

        $laterSetup = $this->makeSetup(1000);
        $active = $this->makeEnrollment($laterSetup, 'active');
        $laterPayment = $this->makePayment($laterSetup, $active, 2, 200);
        $laterResult = $this->runWorker(
            'verify_payment', $laterSetup['staff']->id, $laterPayment->id
        );
        $this->assertSame('accepted', $laterResult['outcome']);
        $this->assertSame(302, $laterResult['status']);
        $this->assertSame('verified', $laterPayment->fresh()->status);
        $this->assertSame($active->id, $laterPayment->fresh()->student_enrollment_id);
        $this->assertSame(1, StudentEnrollment::query()
            ->where('admission_application_id', $laterSetup['application']->id)
            ->count());
    }

    public function test_enrollment_uniqueness_is_present_and_installment_split_payments_are_not_unique(): void
    {
        $this->assertDedicatedDatabase();

        $enrollmentIndexes = DB::select(
            'SELECT INDEX_NAME, NON_UNIQUE, GROUP_CONCAT(COLUMN_NAME ORDER BY SEQ_IN_INDEX) AS indexed_columns '
            . 'FROM information_schema.STATISTICS WHERE TABLE_SCHEMA = ? AND TABLE_NAME = ? '
            . 'GROUP BY INDEX_NAME, NON_UNIQUE',
            [self::DATABASE, 'student_enrollments']
        );
        $paymentIndexes = DB::select(
            'SELECT INDEX_NAME, NON_UNIQUE, GROUP_CONCAT(COLUMN_NAME ORDER BY SEQ_IN_INDEX) AS indexed_columns '
            . 'FROM information_schema.STATISTICS WHERE TABLE_SCHEMA = ? AND TABLE_NAME = ? '
            . 'GROUP BY INDEX_NAME, NON_UNIQUE',
            [self::DATABASE, 'student_fee_payments']
        );

        $this->assertTrue(collect($enrollmentIndexes)->contains(
            fn (object $index): bool => (int) $index->NON_UNIQUE === 0
                && $index->indexed_columns === 'admission_application_id'
        ));
        $this->assertFalse(collect($paymentIndexes)->contains(
            fn (object $index): bool => (int) $index->NON_UNIQUE === 0
                && $index->indexed_columns === 'admission_application_id,installment_number'
        ));
    }

    private function makeSetup(float $fee): array
    {
        $this->assertDedicatedDatabase();

        $student = User::query()->create([
            'name' => 'Concurrency Test Student',
            'email' => uniqid('maria-student-', true) . '@example.test',
            'password' => 'password',
            'role' => 'student',
        ]);
        $staff = User::query()->create([
            'name' => 'Concurrency Test Staff',
            'email' => uniqid('maria-staff-', true) . '@example.test',
            'password' => 'password',
            'role' => 'staff',
        ]);
        $session = AcademicSession::query()->create([
            'name' => 'Concurrency ' . uniqid(),
            'is_active' => true,
        ]);
        $course = Course::query()->create([
            'name' => 'Concurrency Course ' . uniqid(),
            'code' => strtoupper(substr(uniqid('MC'), 0, 12)),
            'annual_fee' => $fee,
        ]);

        $semester = Semester::query()->first();
        if (!$semester) {
            $semester = Semester::query()->create([
                'name' => 'Concurrency Semester 1',
                'semester_number' => 1,
                'is_active' => true,
            ]);
        }

        $application = AdmissionApplication::query()->create([
            'user_id' => $student->id,
            'academic_session_id' => $session->id,
            'course_id' => $course->id,
            'semester_id' => $semester->id,
            'application_no' => uniqid('MARIA-APP-'),
            'status' => 'approved',
        ]);
        $profile = StaffProfile::query()->create([
            'user_id' => $staff->id,
            'employee_code' => uniqid('MARIA-EMP-'),
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
        StaffPermission::query()->create([
            'staff_profile_id' => $profile->id,
            'permission_key' => 'offline_fee_verification',
            'is_active' => true,
        ]);
        CourseFeeStructure::query()->create([
            'course_id' => $course->id,
            'academic_session_id' => $session->id,
            'annual_fee' => $fee,
            'semester_fee' => $fee,
        ]);

        return compact('student', 'staff', 'session', 'course', 'semester', 'application', 'profile');
    }

    private function makeAdmin(): User
    {
        $this->assertDedicatedDatabase();

        return User::query()->create([
            'name' => 'Concurrency Test Admin',
            'email' => uniqid('maria-admin-', true) . '@example.test',
            'password' => 'password',
            'role' => 'admin',
        ]);
    }

    private function makePayment(array $setup, ?StudentEnrollment $enrollment, int $installment, float $amount): StudentFeePayment
    {
        $this->assertDedicatedDatabase();

        return StudentFeePayment::query()->create([
            'admission_application_id' => $setup['application']->id,
            'student_enrollment_id' => $enrollment?->id,
            'semester_id' => $setup['semester']->id,
            'installment_number' => $installment,
            'amount_paid' => $amount,
            'payment_mode' => 'cash',
            'receipt_number' => uniqid('MARIA-R-'),
            'payment_date' => now()->toDateString(),
            'status' => 'pending',
        ]);
    }

    private function makeEnrollment(array $setup, string $status): StudentEnrollment
    {
        $this->assertDedicatedDatabase();

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

    private function runWorker(string $operation, int $actorId, int $recordId, array $payload = []): array
    {
        $this->assertDedicatedDatabase();
        $process = $this->newWorker($operation, $actorId, $recordId, $payload);
        $process->run();

        return $this->decodeWorkerResult($process);
    }

    private function runOverlappingWorkers(int $applicationId, array $workers): array
    {
        $this->assertDedicatedDatabase();
        $connection = DB::connection();
        $connection->beginTransaction();

        $barrierDirectory = sys_get_temp_dir() . DIRECTORY_SEPARATOR . 'fee-concurrency-' . bin2hex(random_bytes(8));
        if (!mkdir($barrierDirectory)) {
            $connection->rollBack();
            $this->fail('Could not create the local concurrency barrier directory.');
        }
        $gatePath = $barrierDirectory . DIRECTORY_SEPARATOR . 'go';
        $processes = [];

        try {
            $connection->table('admission_applications')
                ->where('id', $applicationId)
                ->lockForUpdate()
                ->first();

            foreach ($workers as $index => [$operation, $actorId, $recordId, $payload]) {
                $readyPath = $barrierDirectory . DIRECTORY_SEPARATOR . 'ready-' . $index;
                $attemptPath = $barrierDirectory . DIRECTORY_SEPARATOR . 'attempt-' . $index;
                $process = $this->newWorker(
                    $operation,
                    $actorId,
                    $recordId,
                    $payload,
                    $readyPath,
                    $gatePath,
                    $attemptPath
                );
                $process->start();
                $processes[] = ['process' => $process, 'ready' => $readyPath, 'attempt' => $attemptPath];
            }

            $this->waitFor(static fn (): bool => count(array_filter(
                $processes,
                fn (array $entry): bool => is_file($entry['ready'])
            )) === count($workers), 'worker barrier readiness');

            file_put_contents($gatePath, 'release');
            $this->waitFor(static fn (): bool => count(array_filter(
                $processes,
                fn (array $entry): bool => is_file($entry['attempt'])
            )) === count($workers), 'both workers reaching the controller call barrier');

            // Keep the application-row lock while both independent PHP workers
            // enter the controller actions. A request that skips this mutex
            // would complete before the holder releases the row.
            usleep(500000);
            foreach ($processes as $entry) {
                $this->assertTrue(
                    $entry['process']->isRunning(),
                    'A worker completed while the parent still held the application row lock.'
                );
            }

            $connection->commit();
        } catch (\Throwable $exception) {
            if ($connection->transactionLevel() > 0) {
                $connection->rollBack();
            }
            foreach ($processes as $entry) {
                if ($entry['process']->isRunning()) {
                    $entry['process']->stop(1);
                }
            }
            throw $exception;
        }

        return array_map(function (array $entry): array {
            $entry['process']->wait();

            return $this->decodeWorkerResult($entry['process']);
        }, $processes);
    }

    private function newWorker(
        string $operation,
        int $actorId,
        int $recordId,
        array $payload,
        ?string $readyPath = null,
        ?string $gatePath = null,
        ?string $attemptPath = null
    ): Process {
        $arguments = [
            PHP_BINARY,
            base_path('tests/Support/fee-verification-worker.php'),
            $operation,
            (string) $actorId,
            (string) $recordId,
            json_encode($payload, JSON_THROW_ON_ERROR),
        ];

        if ($readyPath !== null && $gatePath !== null) {
            $arguments[] = $readyPath;
            $arguments[] = $gatePath;
            $arguments[] = $attemptPath;
        }

        return new Process($arguments, sys_get_temp_dir(), [
            'APP_ENV' => 'testing',
            'DB_CONNECTION' => 'mysql',
            'DB_DATABASE' => self::DATABASE,
            'DB_URL' => '',
            'SESSION_DRIVER' => 'array',
            'CACHE_STORE' => 'array',
        ], timeout: 40);
    }

    private function decodeWorkerResult(Process $process): array
    {
        $this->assertSame(0, $process->getExitCode(), $process->getErrorOutput());
        $decoded = json_decode(trim($process->getOutput()), true);
        $this->assertIsArray($decoded, $process->getOutput());

        return $decoded;
    }

    private function waitFor(callable $condition, string $description): void
    {
        $deadline = microtime(true) + 15;
        do {
            if ($condition()) {
                return;
            }
            usleep(20000);
        } while (microtime(true) < $deadline);

        $this->fail('Timed out waiting for ' . $description . '.');
    }

    private function assertDedicatedDatabase(): void
    {
        $connection = DB::connection();
        $selected = $connection->selectOne('SELECT DATABASE() AS db')->db ?? null;

        $this->assertSame(self::DATABASE, $selected, 'Refusing test database access outside the dedicated MariaDB database.');
        $this->assertSame(self::DATABASE, $connection->getDatabaseName());
        $this->assertSame('mysql', $connection->getDriverName());
    }
}
