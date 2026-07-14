<?php

namespace App\Donor\Presentation\Controller;

use App\Shared\Helpers\Session;
use App\Shared\Presentation\View\donorView;
use App\BloodRequest\Domain\Repository\BloodRequestRepositoryInterface;
use App\BloodRequest\Application\UseCase\AcceptBloodRequestUseCase;
use App\BloodRequest\Application\UseCase\DeclineBloodRequestUseCase;
use App\Donor\Domain\Repository\DonorRepositoryInterface;
use App\Notification\Domain\Repository\NotificationRepositoryInterface;
use App\User\Domain\Repository\UserRepositoryInterface;
use App\Donation\Domain\Repository\DonationRepositoryInterface;
use App\Shared\Infrastructure\Persistence\MasterDataRepository;
use App\Donor\Application\UseCase\DonorDonationEligibilityService;
use App\Donor\Application\UseCase\GetDonorProfileUseCase;
use App\Donor\Application\UseCase\GetDonationHistoryUseCase;
use App\Donor\Application\UseCase\UpdateDonorProfileUseCase;

class DonorController
{
    public function __construct(
        private BloodRequestRepositoryInterface $bloodRequestRepo,
        private DonorRepositoryInterface $donorRepo,
        private NotificationRepositoryInterface $notificationRepo,
        private UserRepositoryInterface $userRepo,
        private DonationRepositoryInterface $donationRepo,
        private MasterDataRepository $masterRepo,
        private DonorDonationEligibilityService $eligibilityService,
        private AcceptBloodRequestUseCase $acceptUseCase,
        private DeclineBloodRequestUseCase $declineUseCase,
        private GetDonorProfileUseCase $getDonorProfileUseCase,
        private GetDonationHistoryUseCase $getDonationHistoryUseCase,
        private UpdateDonorProfileUseCase $updateDonorProfileUseCase
    ) {}

    private function authGuard()
    {
        Session::start();

        if (!Session::has('user_id')) {
            header('Location: /BloodConnect/public/login');
            exit;
        }
    }

    private function getUserId(): int
    {
        return (int) Session::get('user_id');
    }

    private function getUnreadCount(): int
    {
        return $this->notificationRepo->getUnreadCount($this->getUserId());
    }





    public function donor_dashboard()
    {
        $this->authGuard();

        $user = Session::get('user');
        $bloodGroup = '';

        if (is_array($user)) {
            $bloodGroup = trim((string)($user['blood_group'] ?? ''));
        }

        if ($bloodGroup === '') {
            $donor = $this->donorRepo->findById((int)Session::get('user_id'));
            $bloodGroup = trim((string)($donor['blood_group'] ?? ''));
        }

        $acceptedStatus = $this->masterRepo->getId('REQUEST_STATUS', 'ACCEPTED') ?? 8;
        $pendingRequests = $this->bloodRequestRepo->findPendingRequestsForDonor($bloodGroup);
        $acceptedRequests = $this->bloodRequestRepo->findAcceptedRequestsForDonor((int)Session::get('user_id'), (int)$acceptedStatus);
        $lastDonation = $acceptedRequests[0] ?? [];
        $combinedRequests = array_merge($pendingRequests, $acceptedRequests);
        $lastDonationDate = !empty($lastDonation['created_at']) ? (string)$lastDonation['created_at'] : '';
        $availabilityState = $this->donorRepo->syncAvailabilityStatus((int)Session::get('user_id'));
        $eligibility = $this->eligibilityService->evaluate($lastDonationDate, $availabilityState['next_available_date']);

        // Build recent activity feed
        $activities = [];
        foreach ($acceptedRequests as $req) {
            if (!empty($req['created_at'])) {
                $activities[] = [
                    'type' => 'accepted',
                    'label' => 'Accepted request ' . ($req['request_code'] ?? 'BR-' . str_pad((string)($req['request_id'] ?? 0), 3, '0', STR_PAD_LEFT)),
                    'timestamp' => $req['created_at'],
                ];
            }
        }
        $donations = $this->donationRepo->findByDonor((int)Session::get('user_id'));
        foreach ($donations as $donation) {
            $date = $donation['donation_date'] ?? $donation['created_at'] ?? '';
            if (!empty($date)) {
                $activities[] = [
                    'type' => 'donation',
                    'label' => 'Donation completed' . (!empty($donation['request_code']) ? ' (' . $donation['request_code'] . ')' : ''),
                    'timestamp' => $date,
                ];
            }
        }
        $activities[] = [
            'type' => 'availability',
            'label' => 'Changed availability to ' . ($availabilityState['available'] ? 'Available' : 'Unavailable'),
            'timestamp' => date('Y-m-d H:i:s'),
        ];
        usort($activities, function ($a, $b) {
            return strtotime($b['timestamp']) - strtotime($a['timestamp']);
        });

        donorView::render('donor_dashboard', [
            'user' => $user,
            'blood_group' => $bloodGroup,
            'availability' => $availabilityState['available'] ? 'Available' : 'Unavailable',
            'availability_message' => $availabilityState['available']
                ? $eligibility['message']
                : ($availabilityState['next_available_date'] ? '' : $eligibility['message']),
            'next_eligible_date' => $availabilityState['available'] ? '' : ($availabilityState['next_available_date'] ?? $eligibility['next_eligible_date']),
            'last_donation_date' => !empty($lastDonationDate)
                ? date('d M Y', strtotime($lastDonationDate))
                : 'No donation yet',
            'last_donation_location' => $lastDonation['hospital_name'] ?? 'No location saved',
            'blood_requests' => $combinedRequests,
            'pending_requests_count' => count($pendingRequests),
            'total_donations' => count($donations),
            'recent_activities' => $activities,
        ]);
    }





    public function acceptRequest()
    {
        $this->authGuard();

        $donorId = (int)(Session::get('user')['user_id'] ?? 0);
        $requestId = (int)$_POST['request_id'];

        $result = $this->acceptUseCase->execute($requestId, $donorId);

        if (!$result['success']) {
            Session::set('flash_message', $result['error']);
            Session::set('flash_status', 'error');
            header('Location: /BloodConnect/public/donor/blood-requests');
            exit;
        }

        header('Location: /BloodConnect/public/donor/dashboard');
        exit;
    }






    public function declineRequest()
    {
        $this->authGuard();

        $donorId = (int)(Session::get('user')['user_id'] ?? 0);
        $requestId = (int)$_POST['request_id'];

        $result = $this->declineUseCase->execute($requestId, $donorId);

        if (!$result['success']) {
            echo $result['error'];
            exit;
        }

        header('Location: /BloodConnect/public/donor/dashboard');
        exit;
    }

    public function profile()
    {
        $this->authGuard();

        $profile = $this->getDonorProfileUseCase->execute((int)Session::get('user_id'));

        donorView::render('donor_profile', [
            'user' => Session::get('user'),
            'availability' => $profile['availability_state']['available'] ? 'Available' : 'Unavailable',
            'availability_message' => $profile['availability_state']['available']
                ? $profile['eligibility']['message']
                : ($profile['availability_state']['next_available_date'] ? 'You will be eligible again after the waiting period.' : $profile['eligibility']['message']),
            'next_eligible_date' => $profile['availability_state']['available'] ? '' : ($profile['availability_state']['next_available_date'] ?? $profile['eligibility']['next_eligible_date'])
        ]);
    }

    public function bloodRequests()
    {
        $this->authGuard();

        $user = Session::get('user');
        $bloodGroup = '';

        if (is_array($user)) {
            $bloodGroup = trim((string)($user['blood_group'] ?? ''));
        }

        if ($bloodGroup === '') {
            $donor = $this->donorRepo->findById((int)Session::get('user_id'));
            $bloodGroup = trim((string)($donor['blood_group'] ?? ''));
        }

        $acceptedStatus = $this->masterRepo->getId('REQUEST_STATUS', 'ACCEPTED') ?? 8;
        $pendingRequests = $this->bloodRequestRepo->findPendingRequestsForDonor($bloodGroup);
        $acceptedRequests = $this->bloodRequestRepo->findAcceptedRequestsForDonor((int)Session::get('user_id'), $acceptedStatus);
        $combinedRequests = array_merge($pendingRequests, $acceptedRequests);

        $message = Session::get('flash_message', '');
        $status = Session::get('flash_status', '');
        Session::remove('flash_message');
        Session::remove('flash_status');

        donorView::render('blood_requests', [
            'user' => $user,
            'blood_group' => $bloodGroup,
            'requests' => $combinedRequests,
            'message' => $message,
            'status'  => $status,
        ]);
    }

    public function bloodRequestDetails(int $requestId)
    {
        $this->authGuard();

        $request = $this->bloodRequestRepo->findById($requestId);

        if (!$request) {
            die('Blood request not found.');
        }

        $pendingStatusId = $this->masterRepo->getId('REQUEST_STATUS', 'PENDING') ?? 7;
        if ((int)($request['status'] ?? 0) === $pendingStatusId) {
            if (!isset($_SESSION['viewed_pending_requests']) || !is_array($_SESSION['viewed_pending_requests'])) {
                $_SESSION['viewed_pending_requests'] = [];
            }
            if (!in_array($requestId, $_SESSION['viewed_pending_requests'])) {
                $_SESSION['viewed_pending_requests'][] = $requestId;
            }
        }

        donorView::render('blood_request_details', [
            'user' => Session::get('user'),
            'request' => $request,
        ]);
    }

    public function history()
    {
        $this->authGuard();

        donorView::render('donation_history', [
            'user' => Session::get('user'),
            'requests' => $this->getDonationHistoryUseCase->execute((int)Session::get('user_id')),
        ]);
    }

    public function viewHistory()
    {
        $this->authGuard();

        $requestId = (int)($_GET['id'] ?? 0);

        if (!$requestId) {
            header('Location: /BloodConnect/public/donor/history');
            exit;
        }

        $acceptedStatus = $this->masterRepo->getId('REQUEST_STATUS', 'ACCEPTED') ?? 8;
        $request = $this->bloodRequestRepo->findDonorRequestDetail($requestId, (int)Session::get('user_id'), (int)$acceptedStatus);

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

        donorView::render('update_profile', [
            'user' => Session::get('user')
        ]);
    }

    public function notifications()
    {
        $this->authGuard();

        donorView::render('notification', [
            'notifications' => $this->notificationRepo->findByUserId($this->getUserId()),
            'unreadCount' => $this->getUnreadCount()
        ]);
    }

    public function markNotificationRead()
    {
        $this->authGuard();

        $id = (int)($_POST['notification_id'] ?? 0);
        $success = $this->notificationRepo->markAsRead($id);

        header('Content-Type: application/json');
        echo json_encode([
            'success' => $success,
            'count' => $this->notificationRepo->getUnreadCount($this->getUserId())
        ]);
        exit;
    }

    public function markAllNotificationsRead()
    {
        $this->authGuard();

        $success = $this->notificationRepo->markAllAsRead($this->getUserId());

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

        header('Content-Type: application/json');
        echo json_encode([
            'count' => $this->notificationRepo->getUnreadCount($this->getUserId())
        ]);
        exit;
    }

    public function updateProfile()
    {
        $this->authGuard();

        $userId = (int)Session::get('user_id');

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

        $result = $this->updateDonorProfileUseCase->execute($userId, $data);

        if (!$result['success']) {
            die($result['error']);
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
