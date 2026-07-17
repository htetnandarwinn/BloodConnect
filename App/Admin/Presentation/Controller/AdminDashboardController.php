<?php

namespace App\Admin\Presentation\Controller;

use App\User\Domain\Repository\UserRepositoryInterface;
use App\BloodRequest\Domain\Repository\BloodRequestRepositoryInterface;
use App\Notification\Domain\Repository\NotificationRepositoryInterface;
use App\Shared\Infrastructure\Activity\ActivityLogger;
use App\Shared\Helpers\Session;

class AdminDashboardController
{
    public function __construct(
        private UserRepositoryInterface $userRepo,
        private BloodRequestRepositoryInterface $requestRepo,
        private NotificationRepositoryInterface $notificationRepo,
        private ActivityLogger $activityLogger
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
            'adminName'         => $_SESSION['user']['username'] ?? 'Admin',
            'activities'        => $this->activityLogger->getLatest(10)
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

    public function updateProfilePage(): void
    {
        $userId = (int)($_SESSION['user_id'] ?? 0);
        $existing = $userId ? $this->userRepo->findById($userId) : [];

        $user = [
            'user_id'  => $userId,
            'username' => $existing['username'] ?? ($_SESSION['user']['username'] ?? ''),
            'email'    => $existing['email'] ?? ($_SESSION['user']['email'] ?? ''),
            'phone'    => $existing['phone'] ?? ''
        ];

        $message = Session::get('profile_message', '');
        $status = Session::get('profile_status', '');
        Session::remove('profile_message');
        Session::remove('profile_status');

        ob_start();
        require __DIR__ . '/../View/admin_update_profile.php';
        $content = ob_get_clean();
        require __DIR__ . '/../Layout/adminApp.php';
    }

    public function updateProfile(): void
    {
        $userId = (int)($_SESSION['user_id'] ?? 0);

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = trim((string)($_POST['username'] ?? ''));
            $email = trim((string)($_POST['email'] ?? ''));
            $phone = trim((string)($_POST['phone'] ?? ''));
            $newPassword = $_POST['new_password'] ?? '';
            $confirmPassword = $_POST['confirm_password'] ?? '';

            if ($username === '' || $email === '') {
                Session::set('profile_message', 'Username and email are required.');
                Session::set('profile_status', 'error');
                header('Location: /BloodConnect/public/admin/profile/update');
                exit;
            }

            if (!empty($newPassword) && $newPassword !== $confirmPassword) {
                Session::set('profile_message', 'Passwords do not match.');
                Session::set('profile_status', 'error');
                header('Location: /BloodConnect/public/admin/profile/update');
                exit;
            }

            $existing = $userId ? $this->userRepo->findById($userId) : [];

            $data = [
                'username'    => $username,
                'email'       => $email,
                'phone'       => $phone,
                'blood_group' => $existing['blood_group'] ?? null,
                'address'     => $existing['address'] ?? null
            ];

            if (!empty($newPassword)) {
                $data['password'] = $newPassword;
            }

            if ($userId) {
                $this->userRepo->update($userId, $data);

                $_SESSION['user']['username'] = $username;
                $_SESSION['user']['email'] = $email;

                $actorName = $_SESSION['user']['username'] ?? 'Admin';

                $admins = $this->notificationRepo->getAdmins();
                foreach ($admins as $admin) {
                    $adminUserId = (int)($admin['user_id'] ?? 0);
                    if ($adminUserId > 0) {
                        $this->notificationRepo->create(
                            $adminUserId,
                            'Admin Profile Updated',
                            sprintf(
                                'Admin %s updated their own profile (ID: %s).',
                                $actorName,
                                $userId
                            ),
                            'ADMIN_ACTION'
                        );
                    }
                }

                Session::set('profile_message', 'Profile updated successfully.');
                Session::set('profile_status', 'success');
            }
        }

        header('Location: /BloodConnect/public/admin/profile');
        exit;
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
