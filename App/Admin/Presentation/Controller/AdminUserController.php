<?php

namespace App\Admin\Presentation\Controller;

use App\Admin\Application\UseCase\ManageUsersUseCase;
use App\Shared\Helpers\Session;

class AdminUserController
{
    public function __construct(
        private ManageUsersUseCase $manageUsersUseCase
    ) {}

    public function userManagement(): void
    {
        $users = $this->manageUsersUseCase->getAllUsers();

        ob_start();
        require __DIR__ . '/../View/user_management.php';
        $content = ob_get_clean();
        require __DIR__ . '/../Layout/adminApp.php';
    }

    public function viewUser(): void
    {
        ob_start();
        require __DIR__ . '/../View/view_user.php';
        $content = ob_get_clean();
        require __DIR__ . '/../Layout/adminApp.php';
    }

    public function editUser(): void
    {
        $id = $_GET['id'] ?? null;

        if (!$id) {
            header("Location: /BloodConnect/public/admin/user-management");
            exit;
        }

        $user = $this->manageUsersUseCase->getUserById((int)$id);

        if (!$user) {
            header("Location: /BloodConnect/public/admin/user-management");
            exit;
        }

        ob_start();
        require __DIR__ . '/../View/edit_user.php';
        $content = ob_get_clean();
        require __DIR__ . '/../Layout/adminApp.php';
    }

    public function updateUser(): void
    {
        $id = (int)($_POST['user_id'] ?? 0);
        $username = trim($_POST['username'] ?? '');
        $email = trim($_POST['email'] ?? '');
        $role = (int)($_POST['user_type_id'] ?? 3);
        $status = (int)($_POST['is_active'] ?? 1);

        if (!$id) {
            header("Location: /BloodConnect/public/admin/user-management");
            exit;
        }

        Session::start();
        $adminId = Session::get('user_id');
        $adminName = Session::get('username');

        $result = $this->manageUsersUseCase->updateUser(
            $id,
            [
                'username' => $username,
                'email' => $email,
                'user_type_id' => $role,
                'is_active' => $status,
            ],
            $adminId,
            $adminName
        );

        if (!$result['success']) {
            Session::set('flash_message', $result['error']);
            Session::set('flash_status', 'error');
        }

        header("Location: /BloodConnect/public/admin/user-management");
        exit;
    }

    public function deleteUser(): void
    {
        $id = (int)($_GET['id'] ?? 0);
        $referer = $_SERVER['HTTP_REFERER'] ?? '/BloodConnect/public/admin/user-management';

        if (!$id) {
            header("Location: " . $referer);
            exit;
        }

        Session::start();
        $adminId = Session::get('user_id');
        $adminName = Session::get('username');

        $this->manageUsersUseCase->deleteUser($id, $adminId, $adminName);

        header("Location: " . $referer);
        exit;
    }
}
