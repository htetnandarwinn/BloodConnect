<?php

namespace App\Shared\Helpers;

class PermissionGuard
{
    public static function check(string $permission): void
    {
        if (Permission::can($permission)) {
            return;
        }

        http_response_code(403);

        require __DIR__ . '/../Presentation/View/403.php';
        exit;
    }
}
