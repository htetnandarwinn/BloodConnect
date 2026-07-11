<?php

namespace App\Notification\Application\UseCase;

use App\Notification\Domain\Repository\NotificationRepositoryInterface;

readonly class MarkNotificationReadUseCase
{
    public function __construct(
        private NotificationRepositoryInterface $repo
    ) {}

    public function execute(int $notificationId): bool
    {
        return $this->repo->markAsRead($notificationId);
    }
}
