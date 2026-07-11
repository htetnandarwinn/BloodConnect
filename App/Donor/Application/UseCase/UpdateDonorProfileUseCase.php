<?php

namespace App\Donor\Application\UseCase;

use App\Donor\Domain\Repository\DonorRepositoryInterface;
use App\Notification\Domain\Repository\NotificationRepositoryInterface;
use App\User\Domain\Repository\UserRepositoryInterface;

class UpdateDonorProfileUseCase
{
    public function __construct(
        private DonorRepositoryInterface $donorRepo,
        private NotificationRepositoryInterface $notificationRepo,
        private UserRepositoryInterface $userRepo
    ) {}

    public function execute(int $userId, array $data): array
    {
        $success = $this->donorRepo->updateProfile($userId, $data);
        if (!$success) {
            return ['success' => false, 'error' => 'Update failed.'];
        }

        $this->notificationRepo->create(
            $userId,
            'Profile Updated',
            'Your donor profile has been updated successfully.',
            'PROFILE_UPDATE'
        );

        $admins = $this->userRepo->getAdmins();
        foreach ($admins as $admin) {
            $this->notificationRepo->create(
                (int)$admin['user_id'],
                'Donor Profile Updated',
                sprintf('%s updated their donor profile information.', $data['username'] ?? 'A donor'),
                'PROFILE_UPDATE'
            );
        }

        return ['success' => true];
    }
}
