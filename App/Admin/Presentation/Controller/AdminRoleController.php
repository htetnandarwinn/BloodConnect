<?php

namespace App\Admin\Presentation\Controller;

use App\Shared\Infrastructure\Persistence\RoleRepository;
use App\Notification\Domain\Repository\NotificationRepositoryInterface;

class AdminRoleController
{
    public function __construct(
        private RoleRepository $roleRepo,
        private NotificationRepositoryInterface $notificationRepo
    ) {}

    public function roles(): void
    {
        $roles = $this->roleRepo->getAllRoles();

        ob_start();
        require __DIR__ . '/../View/roles.php';
        $content = ob_get_clean();
        require __DIR__ . '/../Layout/adminApp.php';
    }

    public function editRole(int $id): void
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $roleId = $_POST['role_id'] ?? null;
            $permissions = $_POST['permissions'] ?? [];

            if (!$roleId) {
                die("Role ID missing.");
            }

            $this->roleRepo->updateRolePermissions((int)$roleId, $permissions);

            $role = $this->roleRepo->findById((int)$roleId);
            $adminName = $_SESSION['user']['username'] ?? 'Admin';
            $adminId = (int)($_SESSION['user_id'] ?? 0);

            $admins = $this->notificationRepo->getAdmins();
            foreach ($admins as $admin) {
                $adminUserId = (int)($admin['user_id'] ?? 0);
                if ($adminUserId > 0 && $adminUserId !== $adminId) {
                    $this->notificationRepo->create(
                        $adminUserId,
                        'Role Permissions Updated',
                        sprintf(
                            'Admin %s updated permissions for role "%s" (%d permissions).',
                            $adminName,
                            $role['name'] ?? 'Unknown',
                            count($permissions)
                        ),
                        'ADMIN_ACTION'
                    );
                }
            }

            header("Location: /BloodConnect/public/admin/roles");
            exit;
        }

        $role = $this->roleRepo->findById($id);

        if (!$role) {
            http_response_code(404);
            exit('Role not found.');
        }

        $permissions = $this->roleRepo->getAllPermissions();
        $rolePermissions = $this->roleRepo->getRolePermissionIds($id);

        $groups = [];
        foreach ($permissions as $permission) {
            $key = explode('.', $permission['permission_key'])[0];
            $groups[$key][] = $permission;
        }

        ob_start();
        require __DIR__ . '/../View/edit_role.php';
        $content = ob_get_clean();
        require __DIR__ . '/../Layout/adminApp.php';
    }

    public function updateRolePermissions(): void
    {
        $id = $_POST['role_id'] ?? null;

        if (!$id) {
            die("Role ID missing.");
        }

        $permissionIds = $_POST['permissions'] ?? [];

        $this->roleRepo->updateRolePermissions((int)$id, $permissionIds);

        header("Location: /BloodConnect/public/admin/roles");
        exit;
    }
}
