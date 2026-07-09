<?php

namespace App\User\Presentation\Controller;

use App\Shared\Helpers\Session;
use App\Shared\Presentation\View\patientView;
use App\User\Infrastructure\Persistence\UserRepository;
use App\Shared\Helpers\Validator;
use App\BloodRequest\Infrastructure\Persistence\BloodRequestRepository;
use App\Notification\Application\UseCase\SendProfileUpdateNotificationUseCase;
use App\Notification\Infrastructure\Persistence\NotificationRepository;
use App\Shared\Helpers\PermissionGuard;

class PatientController
{
    private function getUserId(): int
    {
        return (int) Session::get('user_id');
    }

    private function getUnreadCount(): int
    {
        $repo = new NotificationRepository();
        return $repo->getUnreadCount($this->getUserId());
    }

    private function authGuard()
    {
        Session::start();

        if (!Session::has('user_id')) {
            header('Location: /BloodConnect/public/login');
            exit;
        }
    }
    public function patient_dashboard()
    {


        $this->authGuard();
        PermissionGuard::check('dashboard.view');


        $repo = new BloodRequestRepository();
        $patientId = $this->getUserId();

        return patientView::render('patient_dashboard', [
            'username'    => Session::get('username'),
            'requests'    => $repo->findByPatientId($patientId),
            'metrics'     => $repo->getPatientStats($patientId),
            'unreadCount' => $this->getUnreadCount()
        ]);
    }

    public function myRequests()
    {
        $this->authGuard();
        PermissionGuard::check('blood_request.view_own');


        $repo = new BloodRequestRepository();

        return patientView::render('myrequest', [
            'username'    => Session::get('username'),
            'requests'    => $repo->findByPatientId($this->getUserId()),
            'unreadCount' => $this->getUnreadCount()
        ]);
    }

    public function viewMyRequest()
    {
        $this->authGuard();
        PermissionGuard::check('blood_request.view_own');

        $requestId = (int)($_GET['id'] ?? 0);

        if (!$requestId) {
            header('Location: /BloodConnect/public/patient/my-requests');
            exit;
        }

        $repo = new BloodRequestRepository();
        $request = $repo->findPatientRequestDetail($requestId, $this->getUserId());

        if (empty($request)) {
            header('Location: /BloodConnect/public/patient/my-requests');
            exit;
        }

        return patientView::render('request_detail', [
            'username'    => Session::get('username'),
            'request'     => $request,
            'unreadCount' => $this->getUnreadCount()
        ]);
    }

    public function profile()
    {
        $this->authGuard();
        PermissionGuard::check('profile.view');


        $repo = new UserRepository();

        return patientView::render('patientProfile', [
            'user'        => $repo->findById($this->getUserId()),
            'unreadCount' => $this->getUnreadCount()
        ]);
    }

    public function updateProfile()
    {
        $this->authGuard();
        PermissionGuard::check('profile.update');

        $userId = $this->getUserId();

        $password = trim($_POST['password'] ?? $_POST['new_password'] ?? '');
        $confirmPassword = trim($_POST['confirm_password'] ?? '');

        $data = [
            'username'         => trim($_POST['username'] ?? ''),
            'email'            => trim($_POST['email'] ?? ''),
            'phone'            => trim($_POST['phone'] ?? ''),
            'blood_group'      => trim($_POST['blood_group'] ?? ''),
            'address'          => trim($_POST['address'] ?? ''),
            'password'         => $password,
            'confirm_password' => $confirmPassword,
        ];

        $validator = new Validator();

        $validator
            ->required('username', $data['username'])
            ->required('email', $data['email'])
            ->email('email', $data['email'])
            ->required('phone', $data['phone'])
            ->digits('phone', $data['phone'])
            ->lengthBetween('phone', $data['phone'], 11, 11)
            ->myanmarPhone('phone', $data['phone'])
            ->required('blood_group', $data['blood_group'])
            ->required('address', $data['address']);

        if ($validator->fails()) {
            print_r($validator->getErrors());
            exit;
        }

        // Password is optional
        if (!empty($data['password'])) {

            if ($data['password'] !== $data['confirm_password']) {
                die("Passwords do not match.");
            }

            $data['password'] = password_hash(
                $data['password'],
                PASSWORD_BCRYPT
            );
        } else {
            unset($data['password']);
        }

        $repo = new UserRepository();

        if (!$repo->update($userId, $data)) {
            die("Update failed!");
        }

        Session::set('username', $data['username']);
        Session::set('email', $data['email']);

        $userSession = Session::get('user');
        if (is_array($userSession)) {
            $userSession['username'] = $data['username'];
            $userSession['email'] = $data['email'];
            Session::set('user', $userSession);
        }

        $notificationUseCase = new SendProfileUpdateNotificationUseCase();
        $notificationUseCase->execute($userId, $data['username']);

        header("Location: /BloodConnect/public/patient/profile");
        exit;
    }

    public function searchDonors()
    {
        $this->authGuard();
        PermissionGuard::check('donor.search');


        return patientView::render('search_donors', [
            'username'    => Session::get('username'),
            'unreadCount' => $this->getUnreadCount()
        ]);
    }

    public function notifications()
    {
        $this->authGuard();
        PermissionGuard::check('notification.view');


        $repo = new NotificationRepository();
        $patientId = $this->getUserId();

        return patientView::render('notification', [
            'username'      => Session::get('username'),
            'notifications' => $repo->findByUserId($patientId),
            'unreadCount'   => $this->getUnreadCount()
        ]);
    }

    public function updateProfilePage()
    {
        $this->authGuard();
        PermissionGuard::check('profile.view');

        $repo = new UserRepository();

        return patientView::render('update_profile', [
            'user' => $repo->findById($this->getUserId()),
            'unreadCount' => $this->getUnreadCount()
        ]);
    }

    public function markNotificationRead()
    {
        $this->authGuard();
        PermissionGuard::check('notification.view');

        $id = (int)($_POST['notification_id'] ?? 0);

        $repo = new NotificationRepository();

        $success = $repo->markAsRead($id);

        header('Content-Type: application/json');

        echo json_encode([
            "success" => $success,
            "count" => $repo->getUnreadCount($this->getUserId())
        ]);

        exit;
    }

    public function markAllNotificationsRead()
    {
        $this->authGuard();
        PermissionGuard::check('notification.view');

        $repo = new NotificationRepository();

        $success = $repo->markAllAsRead($this->getUserId());

        header('Content-Type: application/json');

        echo json_encode([
            "success" => $success,
            "count" => 0
        ]);

        exit;
    }

    public function unreadCount()
    {
        $this->authGuard();
        PermissionGuard::check('notification.view');

        $repo = new NotificationRepository();

        header('Content-Type: application/json');

        echo json_encode([
            'count' => $repo->getUnreadCount($this->getUserId())
        ]);

        exit;
    }
    public function getPatientStats(int $patientId): array
    {
        // Delegate to BloodRequestRepository to avoid direct DB access here
        $repo = new \App\BloodRequest\Infrastructure\Persistence\BloodRequestRepository();
        return $repo->getPatientStats($patientId);
    }
}
