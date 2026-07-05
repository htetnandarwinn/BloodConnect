<?php

namespace App\Notification\Application\UseCase;

use App\Notification\Infrastructure\Persistence\NotificationRepository;

class MarkNotificationReadUseCase
{
    private NotificationRepository $repo;

    public function __construct()
    {
        $this->repo = new NotificationRepository();
    }

    public function execute(int $notificationId): bool
    {
        return $this->repo->markAsRead($notificationId);
    }
}
