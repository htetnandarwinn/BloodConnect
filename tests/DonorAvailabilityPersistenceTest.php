<?php

require __DIR__ . '/../vendor/autoload.php';

use App\Donor\Infrastructure\Persistence\DonorRepository;
use App\Shared\Infrastructure\Database\Database;

function assertTrue(bool $condition, string $message): void
{
    if (!$condition) {
        fwrite(STDERR, "FAILED: $message\n");
        exit(1);
    }
}

$pdo = Database::getConnection();
$repo = new DonorRepository();

$email = 'availability-test-' . time() . '@example.com';
$insert = $pdo->prepare(
    "INSERT INTO users (email, password, status_id, available, next_available_date, username, user_type_id, is_active, is_login, is_verified) VALUES (?, ?, 1, 1, NULL, ?, 2, 1, 0, 1)"
);
$insert->execute([$email, password_hash('secret', PASSWORD_BCRYPT), 'availability-test']);
$userId = (int) $pdo->lastInsertId();

try {
    $repo->saveNextAvailableDate($userId, date('Y-m-d H:i:s', strtotime('-1 day')));
    $state = $repo->syncAvailabilityStatus($userId);
    assertTrue($state['available'] === true, 'Expired next_available_date should auto-enable the donor');
    assertTrue($state['next_available_date'] === null, 'Expired next_available_date should be cleared');

    $repo->saveNextAvailableDate($userId, date('Y-m-d H:i:s', strtotime('+1 day')));
    $state = $repo->syncAvailabilityStatus($userId);
    assertTrue($state['available'] === false, 'Future next_available_date should keep the donor unavailable');
    assertTrue($state['next_available_date'] !== null, 'Future next_available_date should be preserved');
} finally {
    $pdo->prepare('DELETE FROM users WHERE user_id = ?')->execute([$userId]);
}

echo "Donor availability persistence tests passed\n";
