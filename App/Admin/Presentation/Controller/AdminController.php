<?php

namespace App\Admin\Presentation\Controller;

use App\Shared\Helpers\Session;
use App\User\Infrastructure\Persistence\UserRepository;
use App\BloodRequest\Infrastructure\Persistence\BloodRequestRepository;

class AdminController
{
    /**
     * AUTH GUARD (SAFE + CLEAN)
     */
    private function authGuard(): void
    {
        Session::start();

        $user = $_SESSION['user'] ?? null;

        if (
            !$user ||
            !isset($user['user_type_id']) ||
            (int)$user['user_type_id'] !== 1
        ) {
            header("Location: /BloodConnect/public/login");
            exit;
        }
    }

    /**
     * ADMIN DASHBOARD
     */
    public function admin_dashboard(): void
    {
        $this->authGuard();

        $userRepo = new UserRepository();
        $requestRepo = new BloodRequestRepository();

        $users = method_exists($userRepo, 'findAll') ? $userRepo->findAll() : [];
        $requests = method_exists($requestRepo, 'findAll') ? $requestRepo->findAll() : [];

        $totalDonors = 0;
        $totalPatients = 0;

        foreach ($users as $user) {
            $type = (int)($user['user_type_id'] ?? 0);

            if ($type === 2) $totalDonors++;
            elseif ($type === 3) $totalPatients++;
        }

        $pendingRequests = 0;
        $completedRequests = 0;

        foreach ($requests as $request) {
            $status = strtolower(trim($request['status'] ?? ''));

            if ($status === 'pending') $pendingRequests++;
            elseif ($status === 'completed') $completedRequests++;
        }

        $data = [
            'totalUsers'        => count($users),
            'totalDonors'       => $totalDonors,
            'totalPatients'     => $totalPatients,
            'totalRequests'     => count($requests),
            'pendingRequests'   => $pendingRequests,
            'completedRequests' => $completedRequests,
            'adminName'         => $_SESSION['user']['username'] ?? 'Admin'
        ];

        ob_start();
        require __DIR__ . '/../View/admin_dashboard.php';
        $content = ob_get_clean();

        require __DIR__ . '/../Layout/adminApp.php';
    }

    /**
     * ADMIN PROFILE
     */
    public function profile(): void
    {
        $this->authGuard();

        Session::start();

        $user = [
            'username' => $_SESSION['user']['username'] ?? 'Admin',
            'role'     => 'Administrator'
        ];

        require __DIR__ . '/../View/admin_profile.php';
    }
}
