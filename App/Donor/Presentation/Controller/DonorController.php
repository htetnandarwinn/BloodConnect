<?php

namespace App\Donor\Presentation\Controller;


use App\Shared\Helpers\Session;
use App\Shared\Presentation\View\donorView;
use App\BloodRequest\Infrastructure\Persistence\BloodRequestRepository;
use App\Donor\Infrastructure\Persistence\DonorRepository;
use App\Notification\Infrastructure\Persistence\NotificationRepository;
use App\Shared\Helpers\PermissionGuard;
use App\Shared\Infrastructure\Persistence\MasterDataRepository;
use App\User\Infrastructure\Persistence\UserRepository;


class DonorController
{


    private function authGuard()
    {

        Session::start();


        if (!Session::has('user_id')) {

            header(
                'Location: /BloodConnect/public/login'
            );

            exit;
        }
    }

    private function getUserId(): int
    {
        return (int) Session::get('user_id');
    }

    private function getUnreadCount(): int
    {
        $repo = new NotificationRepository();
        return $repo->getUnreadCount($this->getUserId());
    }





    public function donor_dashboard()
    {
        $this->authGuard();
        PermissionGuard::check('dashboard.view');



        $user = Session::get('user');
        $bloodGroup = '';

        if (is_array($user)) {
            $bloodGroup = trim((string)($user['blood_group'] ?? ''));
        }

        if ($bloodGroup === '') {
            $donorRepo = new DonorRepository();
            $donor = $donorRepo->findById((int) Session::get('user_id'));
            $bloodGroup = trim((string)($donor['blood_group'] ?? ''));
        }

        $repo = new BloodRequestRepository();
        $acceptedStatus = (new MasterDataRepository())->getId('REQUEST_STATUS', 'ACCEPTED') ?? 8;
        $pendingRequests = $repo->findPendingRequestsForDonor($bloodGroup);
        $acceptedRequests = $repo->findAcceptedRequestsForDonor((int) Session::get('user_id'), (int) $acceptedStatus);
        $lastDonation = $acceptedRequests[0] ?? [];
        $combinedRequests = array_merge($pendingRequests, $acceptedRequests);


        donorView::render(
            'donor_dashboard',
            [

                'user' => $user,


                'blood_group' => $bloodGroup,


                'availability' => (($user['available'] ?? 0) ? 'Available' : 'Unavailable'),

                'last_donation_date' => !empty($lastDonation['created_at'])
                    ? date('d M Y', strtotime($lastDonation['created_at']))
                    : 'No donation yet',

                'last_donation_location' => $lastDonation['hospital_name'] ?? 'No location saved',

                'blood_requests' => $combinedRequests,

                'pending_requests_count' => count($pendingRequests)

            ]
        );
    }





    public function acceptRequest()
    {
        $this->authGuard();
        PermissionGuard::check('blood_request.accept');




        $user = Session::get('user');



        $requestId = (int)$_POST['request_id'];



        $repo = new BloodRequestRepository();



        $updated = $repo->updateDonorDecision(

            $requestId,

            $user['user_id'],

            8   // Accepted

        );



        if (!$updated) {

            die("Failed to accept request");
        }

        $request = $repo->findById($requestId);
        $notificationRepo = new NotificationRepository();
        $userRepo = new UserRepository();
        $donor = $userRepo->findById((int)($user['user_id'] ?? 0));
        $patient = $userRepo->findById((int)($request['patient_id'] ?? 0));
        $admins = $notificationRepo->getAdmins();

        foreach ($admins as $admin) {
            $notificationRepo->create(
                (int)$admin['user_id'],
                'Blood Request Accepted',
                sprintf(
                    'Blood request %s has been accepted by donor %s.',
                    $request['request_code'] ?? 'N/A',
                    $donor['username'] ?? 'Unknown donor'
                ),
                'REQUEST'
            );
        }

        if ($donor) {
            $notificationRepo->create(
                (int)$donor['user_id'],
                'Blood Request Accepted',
                sprintf(
                    'You accepted blood request %s. The patient will be notified shortly.',
                    $request['request_code'] ?? 'N/A'
                ),
                'REQUEST'
            );
        }

        if ($patient) {
            $notificationRepo->create(
                (int)$patient['user_id'],
                'Blood Request Accepted',
                sprintf(
                    'Donor %s has accepted your blood request %s.',
                    $donor['username'] ?? 'A donor',
                    $request['request_code'] ?? 'N/A'
                ),
                'REQUEST'
            );
        }

        header(
            'Location: /BloodConnect/public/donor/dashboard'
        );

        exit;
    }






    public function declineRequest()
    {
        $this->authGuard();
        PermissionGuard::check('blood_request.decline');




        $user = Session::get('user');



        $requestId = (int)$_POST['request_id'];



        $repo = new BloodRequestRepository();



        $updated = $repo->updateDonorDecision(

            $requestId,

            $user['user_id'],

            10   // Declined ID - change after checking master_data

        );



        if (!$updated) {

            die("Failed to decline request");
        }



        header(
            'Location: /BloodConnect/public/donor/dashboard'
        );

        exit;
    }

    public function profile()
    {
        $this->authGuard();
        PermissionGuard::check('profile.view');


        $user = Session::get('user');

        donorView::render('donor_profile', [
            'user' => $user
        ]);
    }

    public function bloodRequests()
    {
        $this->authGuard();
        PermissionGuard::check('blood_request.view_matching');


        $user = Session::get('user');
        $bloodGroup = '';

        if (is_array($user)) {
            $bloodGroup = trim((string)($user['blood_group'] ?? ''));
        }

        if ($bloodGroup === '') {
            $donorRepo = new DonorRepository();
            $donor = $donorRepo->findById((int) Session::get('user_id'));
            $bloodGroup = trim((string)($donor['blood_group'] ?? ''));
        }

        $repo = new BloodRequestRepository();

        donorView::render('blood_requests', [
            'user' => $user,
            'blood_group' => $bloodGroup,
            'requests' => $repo->findPendingRequestsForDonor($bloodGroup),
        ]);
    }

    public function bloodRequestDetails(int $requestId)
    {
        $this->authGuard();
        PermissionGuard::check('blood_request.view_matching');

        $repo = new BloodRequestRepository();
        $request = $repo->findById($requestId);

        if (!$request) {
            die('Blood request not found.');
        }

        donorView::render('blood_request_details', [
            'user' => Session::get('user'),
            'request' => $request,
        ]);
    }

    public function history()
    {
        $this->authGuard();
        PermissionGuard::check('donation_history');

        $acceptedStatus = (new MasterDataRepository())->getId('REQUEST_STATUS', 'ACCEPTED') ?? 8;
        $repo = new BloodRequestRepository();

        donorView::render('donation_history', [
            'user' => Session::get('user'),
            'requests' => $repo->findAcceptedRequestsForDonor((int)Session::get('user_id'), (int)$acceptedStatus),
        ]);
    }

    public function viewHistory()
    {
        $this->authGuard();
        PermissionGuard::check('donation_history');

        $requestId = (int)($_GET['id'] ?? 0);

        if (!$requestId) {
            header('Location: /BloodConnect/public/donor/history');
            exit;
        }

        $acceptedStatus = (new MasterDataRepository())->getId('REQUEST_STATUS', 'ACCEPTED') ?? 8;
        $repo = new BloodRequestRepository();
        $request = $repo->findDonorRequestDetail($requestId, (int)Session::get('user_id'), (int)$acceptedStatus);

        if (empty($request)) {
            header('Location: /BloodConnect/public/donor/history');
            exit;
        }

        donorView::render('donor_request_history_detail', [
            'user' => Session::get('user'),
            'request' => $request,
        ]);
    }

    public function updateProfilePage()
    {
        $this->authGuard();
        PermissionGuard::check('profile.update');


        $user = Session::get('user');

        donorView::render('update_profile', [
            'user' => $user
        ]);
    }

    public function notifications()
    {
        $this->authGuard();
        PermissionGuard::check('notification.view');

        $repo = new NotificationRepository();

        donorView::render('notification', [
            'notifications' => $repo->findByUserId($this->getUserId()),
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
            'success' => $success,
            'count' => $repo->getUnreadCount($this->getUserId())
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
            'success' => $success,
            'count' => 0
        ]);
        exit;
    }

    public function unreadCount()
    {
        $this->authGuard();
        PermissionGuard::check('notifications');

        $repo = new NotificationRepository();

        header('Content-Type: application/json');
        echo json_encode([
            'count' => $repo->getUnreadCount($this->getUserId())
        ]);
        exit;
    }

    public function updateProfile()
    {
        $this->authGuard();
        PermissionGuard::check('profile.update');


        $userId = (int) Session::get('user_id');

        $password = trim($_POST['new_password'] ?? '');
        $confirmPassword = trim($_POST['confirm_password'] ?? '');

        if ($password !== '' && $password !== $confirmPassword) {
            die('Passwords do not match.');
        }

        $userSession = Session::get('user');
        if (!is_array($userSession)) {
            $userSession = [];
        }

        $existingBloodGroup = trim((string)($userSession['blood_group'] ?? ''));

        $data = [
            'username' => trim($_POST['username'] ?? ''),
            'email' => trim($_POST['email'] ?? ''),
            'phone' => trim($_POST['phone'] ?? ''),
            'blood_group' => $existingBloodGroup,
            'address' => trim($_POST['address'] ?? ''),
        ];

        if ($password !== '') {
            $data['password'] = $password;
        }

        $repo = new DonorRepository();

        if (!$repo->updateProfile($userId, $data)) {
            die('Update failed!');
        }

        $notificationRepo = new NotificationRepository();
        $notificationRepo->create(
            $userId,
            'Profile Updated',
            'Your donor profile has been updated successfully.',
            'PROFILE_UPDATE'
        );

        $admins = (new UserRepository())->getAdmins();
        foreach ($admins as $admin) {
            $notificationRepo->create(
                (int)$admin['user_id'],
                'Donor Profile Updated',
                sprintf('%s updated their donor profile information.', $data['username']),
                'PROFILE_UPDATE'
            );
        }

        Session::set('username', $data['username']);
        Session::set('email', $data['email']);

        $userSession = Session::get('user');
        if (!is_array($userSession)) {
            $userSession = [];
        }

        $userSession['username'] = $data['username'];
        $userSession['email'] = $data['email'];
        $userSession['phone'] = $data['phone'];
        $userSession['blood_group'] = $data['blood_group'];
        $userSession['address'] = $data['address'];

        Session::set('user', $userSession);

        header('Location: /BloodConnect/public/donor/profile');
        exit;
    }
}
