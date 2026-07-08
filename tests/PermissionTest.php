<?php

require __DIR__ . '/../vendor/autoload.php';

use App\Shared\Helpers\Permission;

function assertTrue(bool $condition, string $message): void
{
    if (!$condition) {
        fwrite(STDERR, "FAILED: $message\n");
        exit(1);
    }
}

session_start();
$_SESSION['permissions'] = [
    'dashboard.view',
    'blood_request.view_matching',
    'notification.view',
    'profile.view',
];

assertTrue(Permission::can('dashboard') === true, 'dashboard aliases should match dashboard.view');
assertTrue(Permission::can('blood_requests') === true, 'blood_requests aliases should match blood_request.view_matching');
assertTrue(Permission::can('notifications') === true, 'notifications aliases should match notification.view');

assertTrue(Permission::can('availability') === true, 'availability should fall back to dashboard/profile access');

echo "Permission tests passed\n";
