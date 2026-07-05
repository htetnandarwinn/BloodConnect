<?php

namespace App\Notification\Presentation\Controller;

use App\Notification\Application\UseCase\MarkNotificationReadUseCase;
use App\Shared\Helpers\Session;

class NotificationController
{
    public function markAllRead()
    {
        Session::start();

        if (!Session::has('user_id')) {
            http_response_code(403);
            echo json_encode([
                'success' => false
            ]);
            exit;
        }

        $userId = Session::get('user_id');

        $repo = new \App\Notification\Infrastructure\Persistence\NotificationRepository();

        $repo->markAllAsRead($userId);

        $count = $repo->getUnreadCount($userId);

        echo json_encode([
            'success' => true,
            'count' => $count
        ]);
    }
}
