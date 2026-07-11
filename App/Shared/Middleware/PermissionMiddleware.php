<?php

namespace App\Shared\Middleware;

use App\Shared\Helpers\Permission;
use App\Shared\Helpers\Session;

class PermissionMiddleware
{
    private string $permission;

    public function __construct(string $permission)
    {
        $this->permission = $permission;
    }

    public function handle(): void
    {
        Session::start();

        if (!Permission::can($this->permission)) {
            http_response_code(403);
            require __DIR__ . '/../Presentation/View/403.php';
            exit;
        }
    }
}
