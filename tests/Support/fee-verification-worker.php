<?php

require dirname(__DIR__, 2) . '/vendor/autoload.php';

$projectRoot = dirname(__DIR__, 2);

$operation = $argv[1] ?? '';
$actorId = (int) ($argv[2] ?? 0);
$recordId = (int) ($argv[3] ?? 0);
$payload = json_decode($argv[4] ?? '{}', true, flags: JSON_THROW_ON_ERROR);
$readyPath = $argv[5] ?? null;
$gatePath = $argv[6] ?? null;
$attemptPath = $argv[7] ?? null;

$app = require $projectRoot . '/bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

$connection = Illuminate\Support\Facades\DB::connection();
$selectedDatabase = $connection->selectOne('SELECT DATABASE() AS db')->db ?? null;
if ($selectedDatabase !== 'college_erp_concurrency_test'
    || $connection->getDatabaseName() !== 'college_erp_concurrency_test') {
    fwrite(STDERR, "Refusing to run worker outside college_erp_concurrency_test.\n");
    exit(91);
}

$actor = App\Models\User::query()->findOrFail($actorId);
Illuminate\Support\Facades\Auth::guard()->setUser($actor);

if ($readyPath !== null && $gatePath !== null) {
    file_put_contents($readyPath, 'ready');

    $deadline = microtime(true) + 20;
    while (!is_file($gatePath)) {
        if (microtime(true) >= $deadline) {
            fwrite(STDERR, "Worker timed out waiting for its barrier.\n");
            exit(92);
        }
        usleep(10000);
    }

    if ($attemptPath !== null) {
        file_put_contents($attemptPath, 'calling');
    }
}

$request = Illuminate\Http\Request::create('/concurrency-test', 'POST', $payload);
$request->setUserResolver(fn () => $actor);

try {
    $response = match ($operation) {
        'verify_payment' => app(App\Http\Controllers\Staff\StaffFeePaymentsController::class)
            ->verify($request, $recordId),
        'approve_concession' => app(App\Http\Controllers\AdminFeeConcessionController::class)
            ->approve($request, $recordId),
        default => throw new RuntimeException('Unsupported worker operation.'),
    };

    echo json_encode([
        'outcome' => 'accepted',
        'status' => $response->getStatusCode(),
    ], JSON_THROW_ON_ERROR);
} catch (Illuminate\Validation\ValidationException $exception) {
    echo json_encode([
        'outcome' => 'rejected',
        'status' => 422,
        'errors' => $exception->errors(),
    ], JSON_THROW_ON_ERROR);
} catch (Symfony\Component\HttpKernel\Exception\HttpExceptionInterface $exception) {
    echo json_encode([
        'outcome' => 'rejected',
        'status' => $exception->getStatusCode(),
    ], JSON_THROW_ON_ERROR);
} catch (Throwable $exception) {
    fwrite(STDERR, get_class($exception) . ': ' . $exception->getMessage() . "\n");
    exit(1);
}
