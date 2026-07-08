<?php

namespace App\Notification\Application\UseCase;

use App\Notification\Infrastructure\Persistence\NotificationRepository;
use App\User\Infrastructure\Persistence\UserRepository;

class SendProfileUpdateNotificationUseCase
{
    private NotificationRepository $notificationRepo;
    private UserRepository $userRepo;

    public function __construct()
    {
        $this->notificationRepo = new NotificationRepository();
        $this->userRepo = new UserRepository();
    }

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
