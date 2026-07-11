<?php

namespace App\Notification\Domain\Repository;

interface NotificationRepositoryInterface
{
    public function create(int $userId, string $title, string $message, string $type): bool;
    public function findByUserId(int $userId): array;
    public function markAsRead(int $notificationId): bool;
    public function markAllAsRead(int $userId): bool;
    public function getUnreadCount(int $userId): int;
    public function getAdmins(): array;
}
