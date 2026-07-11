<?php

namespace App\Admin\Presentation\Controller;

use App\BloodRequest\Domain\Repository\BloodRequestRepositoryInterface;
use App\Donation\Domain\Repository\DonationRepositoryInterface;
use App\Notification\Domain\Repository\NotificationRepositoryInterface;
use App\User\Domain\Repository\UserRepositoryInterface;
use App\Shared\Infrastructure\Persistence\MasterDataRepository;
use App\Admin\Application\UseCase\ViewBloodRequestsUseCase;
use App\Admin\Application\UseCase\ConfirmDonationUseCase;

class AdminBloodRequestController
{
    public function __construct(
        private BloodRequestRepositoryInterface $bloodRequestRepo,
        private DonationRepositoryInterface $donationRepo,
        private NotificationRepositoryInterface $notificationRepo,
        private UserRepositoryInterface $userRepo,
        private MasterDataRepository $masterRepo,
        private ViewBloodRequestsUseCase $viewUseCase,
        private ConfirmDonationUseCase $confirmUseCase
    ) {}

    public function bloodRequests(): void
    {
        ob_start();
        require __DIR__ . '/../View/blood_requests.php';
        $content = ob_get_clean();
        require __DIR__ . '/../Layout/adminApp.php';
    }

    public function viewBloodRequest(): void
    {
        $requestId = (int)($_GET['id'] ?? 0);

        if (!$requestId) {
            header('Location: /BloodConnect/public/admin/blood-requests');
            exit;
        }

        $request = $this->viewUseCase->getRequestDetail($requestId);

        if (!$request) {
            header('Location: /BloodConnect/public/admin/blood-requests');
            exit;
        }

        $isAccepted = $this->viewUseCase->isRequestAccepted($request);
        $donors = $this->viewUseCase->getMatchingDonors((string)($request['blood_group_needed'] ?? ''));
        $acceptedDonor = null;
        $assignedDonor = null;

        if ($isAccepted && !empty($request['donor_id'])) {
            $acceptedDonor = $this->userRepo->findById((int)$request['donor_id']);
        } elseif (!empty($request['donor_id'])) {
            $assignedDonor = $this->userRepo->findById((int)$request['donor_id']);
        }

        $currentDonorId = (int)($request['donor_id'] ?? 0);
        $donors = array_values(array_filter($donors, function ($d) use ($currentDonorId) {
            return (int)($d['user_id'] ?? 0) !== $currentDonorId;
        }));

        ob_start();
        require __DIR__ . '/../View/blood_request_detail.php';
        $content = ob_get_clean();
        require __DIR__ . '/../Layout/adminApp.php';
    }

    public function acceptBloodRequest(): void
    {
        $requestId = (int)($_POST['request_id'] ?? 0);
        $donorId = (int)($_POST['donor_id'] ?? 0);

        if (!$requestId || !$donorId) {
            header('Location: /BloodConnect/public/admin/blood-requests');
            exit;
        }

        $result = $this->confirmUseCase->assignDonor($requestId, $donorId);

        if (!$result['success']) {
            header('Location: /BloodConnect/public/admin/blood-requests');
            exit;
        }

        header('Location: /BloodConnect/public/admin/blood-requests?success=1');
        exit;
    }

    public function completeRequest(): void
    {
        $requestId = (int)($_GET['id'] ?? 0);

        if (!$requestId) {
            header("Location: /BloodConnect/public/admin/blood-requests");
            exit;
        }

        $result = $this->confirmUseCase->complete($requestId);

        if (!$result['success']) {
            die($result['error']);
        }

        header("Location: /BloodConnect/public/admin/blood-requests");
        exit;
    }
}
