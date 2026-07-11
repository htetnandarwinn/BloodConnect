<?php

namespace App\Admin\Presentation\Controller;

use App\Shared\Infrastructure\Persistence\RoleRepository;

class AdminRoleController
{
    public function __construct(
        private RoleRepository $roleRepo
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
