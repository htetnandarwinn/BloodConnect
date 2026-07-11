<?php

namespace App\Admin\Presentation\Controller;

use App\User\Domain\Repository\UserRepositoryInterface;
use App\Shared\Infrastructure\Database\Database;

class AdminUserController
{
    public function __construct(
        private UserRepositoryInterface $userRepo
    ) {}

    public function userManagement(): void
    {
        $users = $this->userRepo->findAll();

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

        $db = Database::getConnection();
        $stmt = $db->prepare("SELECT user_id, username, email, user_type_id, is_active FROM users WHERE user_id = ?");
        $stmt->execute([$id]);
        $user = $stmt->fetch();

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
        $id = $_POST['user_id'] ?? null;
        $username = $_POST['username'] ?? '';
        $email = $_POST['email'] ?? '';
        $role = $_POST['user_type_id'] ?? 3;
        $status = $_POST['is_active'] ?? 1;

        if (!$id) {
            header("Location: /BloodConnect/public/admin/user-management");
            exit;
        }

        $db = Database::getConnection();
        $stmt = $db->prepare("UPDATE users SET username = ?, email = ?, user_type_id = ?, is_active = ? WHERE user_id = ?");
        $stmt->execute([$username, $email, $role, $status, $id]);

        header("Location: /BloodConnect/public/admin/user-management");
        exit;
    }

    public function deleteUser(): void
    {
        $id = $_GET['id'] ?? null;

        if ($id) {
            $db = Database::getConnection();
            $stmt = $db->prepare("DELETE FROM users WHERE user_id = ?");
            $stmt->execute([$id]);
        }

        header("Location: /BloodConnect/public/admin/user-management");
        exit;
    }
}
