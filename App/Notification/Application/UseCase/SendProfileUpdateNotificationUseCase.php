<?php

namespace App\Notification\Application\UseCase;

use App\Notification\Infrastructure\Persistence\NotificationRepository;

class SendProfileUpdateNotificationUseCase
{
    private NotificationRepository $repo;

    public function __construct()
    {
        $this->repo = new NotificationRepository();
    }

    public function execute(int $userId, string $username): bool
    {
        $title = "Profile Updated";
        $message = "Your profile has been updated successfully.";

        // ✅ FIXED
        $type = "PROFILE_UPDATE";

        return $this->repo->create(
            $userId,
            $title,
            $message,
            $type
        );
    }
}
