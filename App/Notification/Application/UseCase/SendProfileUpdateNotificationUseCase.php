<?php

namespace App\Notification\Application\UseCase;

use App\Notification\Domain\Repository\NotificationRepositoryInterface;
use App\User\Domain\Repository\UserRepositoryInterface;

class SendProfileUpdateNotificationUseCase
{
    public function __construct(
        private NotificationRepositoryInterface $notificationRepo,
        private UserRepositoryInterface $userRepo
    ) {}

    public function execute(int $userId, string $username): void
    {
        // Notification for patient
        $this->notificationRepo->create(
            $userId,
            "Profile Updated",
            "Your profile has been updated successfully.",
            "PROFILE_UPDATE"
        );

        // Notification for admins
        $admins = $this->userRepo->getAdmins();

        foreach ($admins as $admin) {

            $this->notificationRepo->create(
                $admin['user_id'],
                "Patient Profile Updated",
                $username . " updated their profile information.",
                "PROFILE_UPDATE"
            );
        }
    }
}
