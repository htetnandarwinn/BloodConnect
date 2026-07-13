<?php

namespace App\Admin\Presentation\Controller;

use App\User\Domain\Repository\UserRepositoryInterface;
use App\BloodRequest\Domain\Repository\BloodRequestRepositoryInterface;
use App\Notification\Domain\Repository\NotificationRepositoryInterface;

class AdminDashboardController
{
    public function __construct(
        private UserRepositoryInterface $userRepo,
        private BloodRequestRepositoryInterface $requestRepo,
        private NotificationRepositoryInterface $notificationRepo
    ) {}

    public function admin_dashboard(): void
    {
        $users = $this->userRepo->findAll();
        $requests = $this->requestRepo->findAll();

        $totalDonors = 0;
        $totalPatients = 0;
        foreach ($users as $user) {
            $type = (int)($user['user_type_id'] ?? 0);
            if ($type === 2) $totalDonors++;
            elseif ($type === 3) $totalPatients++;
        }

        $pendingRequests = 0;
        $acceptedRequests = 0;

        foreach ($requests as $request) {
            $status = strtolower(trim($request['status_name'] ?? ''));
            if ($status === 'pending') $pendingRequests++;
            elseif ($status === 'accepted' || $status === 'completed') $acceptedRequests++;
        }

        $data = [
            'totalDonors'       => $totalDonors,
            'totalPatients'     => $totalPatients,
            'pendingRequests'   => $pendingRequests,
            'acceptedRequests'  => $acceptedRequests,
            'adminName'         => $_SESSION['user']['username'] ?? 'Admin'
        ];

        ob_start();
        require __DIR__ . '/../View/admin_dashboard.php';
        $content = ob_get_clean();
        require __DIR__ . '/../Layout/adminApp.php';
    }

    public function profile(): void
    {
        $user = [
            'username' => $_SESSION['user']['username'] ?? 'Admin',
            'email'    => $_SESSION['user']['email'] ?? '',
            'role'     => 'Administrator'
        ];

        ob_start();
        require __DIR__ . '/../View/admin_profile.php';
        $content = ob_get_clean();
        require __DIR__ . '/../Layout/adminApp.php';
    }

    public function notifications(): void
    {
        $userId = (int)($_SESSION['user_id'] ?? 0);
        $notifications = [];
        $unreadCount = 0;

        if ($userId) {
            $notifications = $this->notificationRepo->findByUserId($userId);
            $unreadCount = $this->notificationRepo->getUnreadCount($userId);
        }

        ob_start();
        require __DIR__ . '/../View/notification.php';
        $content = ob_get_clean();
        require __DIR__ . '/../Layout/adminApp.php';
    }
}
