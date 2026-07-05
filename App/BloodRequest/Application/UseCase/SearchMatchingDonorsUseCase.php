<?php

namespace App\Notification\Application\UseCase;

use App\Notification\Infrastructure\Persistence\NotificationRepository;

class SendProfileUpdateNotificationUseCase
{
    private NotificationRepository $notificationRepository;

    public function __construct()
    {
        $this->notificationRepository = new NotificationRepository();
    }

    public function execute(int $userId, string $username): void
    {
        $this->notificationRepository->create(
            $userId,
            'Profile Updated',
            "Hi {$username}, your profile has been updated successfully.",
            'APPROVAL'
        );
    }
}
