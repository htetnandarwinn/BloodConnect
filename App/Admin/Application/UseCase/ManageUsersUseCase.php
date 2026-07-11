<?php

namespace App\Admin\Application\UseCase;

use App\User\Domain\Repository\UserRepositoryInterface;
use App\Shared\Infrastructure\Activity\ActivityLogger;

class ManageUsersUseCase
{
    public function __construct(
        private UserRepositoryInterface $userRepo,
        private ActivityLogger $activityLogger
    ) {}

    public function getAllUsers(): array
    {
        return $this->userRepo->findAll();
    }

    public function getUserById(int $id)
    {
        return $this->userRepo->findById($id);
    }

    public function updateUser(int $id, array $data, ?int $adminId = null, ?string $adminName = null): array
    {
        $user = $this->userRepo->findById($id);
        if (!$user) {
            return ['success' => false, 'error' => 'User not found.'];
        }

        $fields = [];
        if (isset($data['username'])) $fields['username'] = $data['username'];
        if (isset($data['email'])) $fields['email'] = $data['email'];
        if (isset($data['phone'])) $fields['phone'] = $data['phone'];
        if (isset($data['user_type_id'])) $fields['user_type_id'] = $data['user_type_id'];
        if (isset($data['is_active'])) $fields['is_active'] = $data['is_active'];

        $this->userRepo->update($id, $fields);

        $this->activityLogger->log(
            $adminId,
            $adminName,
            'USER_UPDATED',
            "Admin updated user {$user['username']} (ID: {$id})"
        );

        return ['success' => true];
    }

    public function deleteUser(int $id, ?int $adminId = null, ?string $adminName = null): array
    {
        $user = $this->userRepo->findById($id);
        if (!$user) {
            return ['success' => false, 'error' => 'User not found.'];
        }

        $this->userRepo->softDelete($id);

        $this->activityLogger->log(
            $adminId,
            $adminName,
            'USER_DELETED',
            "Admin deleted user {$user['username']} (ID: {$id})"
        );

        return ['success' => true];
    }

    public function restoreUser(int $id, ?int $adminId = null, ?string $adminName = null): array
    {
        $this->userRepo->restore($id);

        $this->activityLogger->log(
            $adminId,
            $adminName,
            'USER_RESTORED',
            "Admin restored user ID: {$id}"
        );

        return ['success' => true];
    }
}
