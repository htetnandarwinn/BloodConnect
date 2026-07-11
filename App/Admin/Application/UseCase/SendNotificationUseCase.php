<?php

namespace App\Admin\Application\UseCase;

use App\Notification\Domain\Repository\NotificationRepositoryInterface;
use App\User\Domain\Repository\UserRepositoryInterface;
use App\Shared\Infrastructure\Activity\ActivityLogger;

class SendNotificationUseCase
{
    public function __construct(
        private NotificationRepositoryInterface $notificationRepo,
        private UserRepositoryInterface $userRepo,
        private ActivityLogger $activityLogger
    ) {}

    public function sendToUser(int $userId, string $title, string $message, string $type = 'GENERAL'): array
    {
        $user = $this->userRepo->findById($userId);
        if (!$user) {
            return ['success' => false, 'error' => 'User not found.'];
        }

        $this->notificationRepo->create($userId, $title, $message, $type);

        $this->activityLogger->log(
            null,
            null,
            'NOTIFICATION_SENT',
            "Notification sent to user ID: {$userId} - {$title}"
        );

        return ['success' => true];
    }

    public function sendToAllUsers(string $title, string $message, string $type = 'GENERAL'): array
    {
        $users = $this->userRepo->findAll();
        $count = 0;

        foreach ($users as $user) {
            $this->notificationRepo->create(
                (int)$user['user_id'],
                $title,
                $message,
                $type
            );
            $count++;
        }

        $this->activityLogger->log(
            null,
            null,
            'NOTIFICATION_BROADCAST',
            "Broadcast notification sent to {$count} users - {$title}"
        );

        return ['success' => true, 'count' => $count];
    }

    public function sendToRole(int $userTypeId, string $title, string $message, string $type = 'GENERAL'): array
    {
        $users = $this->userRepo->findAll();
        $count = 0;

        foreach ($users as $user) {
            if ((int)($user['user_type_id'] ?? 0) === $userTypeId) {
                $this->notificationRepo->create(
                    (int)$user['user_id'],
                    $title,
                    $message,
                    $type
                );
                $count++;
            }
        }

        $this->activityLogger->log(
            null,
            null,
            'NOTIFICATION_BROADCAST',
            "Role-based notification sent to {$count} users - {$title}"
        );

        return ['success' => true, 'count' => $count];
    }
}
