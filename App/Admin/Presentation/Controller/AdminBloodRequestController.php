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
        $repo = new \App\BloodRequest\Infrastructure\Persistence\BloodRequestRepository();
        $db = \App\Shared\Infrastructure\Database\Database::getConnection();
        $stmt = $db->prepare("SELECT COUNT(*) FROM blood_requests WHERE status = 7");
        $stmt->execute();
        $_SESSION['pending_blood_requests_viewed_count'] = (int)$stmt->fetchColumn();
        ob_start();
        require __DIR__ . '/../View/blood_requests.php';
        $content = ob_get_clean();
        require __DIR__ . '/../Layout/adminApp.php';
    }

    public function pendingBloodRequestsCount(): void
    {
        header('Content-Type: application/json');
        try {
            $db = \App\Shared\Infrastructure\Database\Database::getConnection();
            $stmt = $db->prepare("SELECT COUNT(*) FROM blood_requests WHERE status = 7");
            $stmt->execute();
            $totalPending = (int)$stmt->fetchColumn();
            $viewedCount = count($_SESSION['viewed_pending_requests'] ?? []);
            echo json_encode(['count' => max(0, $totalPending - $viewedCount)]);
        } catch (Throwable $e) {
            echo json_encode(['count' => 0]);
        }
        exit;
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

        if ((int)$request['status'] === $this->viewUseCase->getPendingStatusId()) {
            if (!isset($_SESSION['viewed_pending_requests']) || !is_array($_SESSION['viewed_pending_requests'])) {
                $_SESSION['viewed_pending_requests'] = [];
            }
            if (!in_array($requestId, $_SESSION['viewed_pending_requests'])) {
                $_SESSION['viewed_pending_requests'][] = $requestId;
            }
        }

        $isAccepted = $this->viewUseCase->isRequestAccepted($request);
        $isCancelledRequest = $this->viewUseCase->isRequestCancelled($request);
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

    public function deleteBloodRequest(): void
    {
        $requestId = (int)($_POST['request_id'] ?? 0);

        if (!$requestId) {
            header('Location: /BloodConnect/public/admin/blood-requests?error=1');
            exit;
        }

        $request = $this->bloodRequestRepo->findById($requestId);
        if (!$request) {
            header('Location: /BloodConnect/public/admin/blood-requests?error=1');
            exit;
        }

        $isPending = (int)($request['status'] ?? 0) === ($this->masterRepo->getId('REQUEST_STATUS', 'PENDING') ?? 7);

        $deleted = $this->bloodRequestRepo->deleteRequest($requestId);

        if (!$deleted) {
            header('Location: /BloodConnect/public/admin/blood-requests?error=1');
            exit;
        }

        if ($isPending) {
            $patientId = (int)($request['patient_id'] ?? 0);
            $donorId = (int)($request['donor_id'] ?? 0);
            $requestCode = (string)($request['request_code'] ?? 'Unknown');
            $patientName = (string)($request['patient_name'] ?? 'A patient');
            $bloodGroup = (string)($request['blood_group_needed'] ?? '');
            $message = "Admin deleted your pending blood request {$requestCode}.";

            if ($patientId > 0) {
                $this->notificationRepo->create($patientId, 'Request Deleted', $message, 'REMINDER');
            }

            $donorIds = [];
            if ($donorId > 0) {
                $donorIds[] = $donorId;
            }

            if ($bloodGroup !== '') {
                $matchingDonors = $this->bloodRequestRepo->getMatchingDonors($bloodGroup);
                foreach ($matchingDonors as $matchedDonor) {
                    $matchedDonorId = (int)($matchedDonor['user_id'] ?? 0);
                    if ($matchedDonorId > 0) {
                        $donorIds[] = $matchedDonorId;
                    }
                }
            }

            foreach (array_unique(array_filter($donorIds)) as $notifyDonorId) {
                $this->notificationRepo->create($notifyDonorId, 'Request Deleted', "The pending blood request {$requestCode} for {$patientName} was removed by admin.", 'REMINDER');
            }

            $admins = $this->userRepo->getAdmins();
            foreach ($admins as $admin) {
                $adminId = (int)($admin['user_id'] ?? 0);
                if ($adminId > 0) {
                    $this->notificationRepo->create($adminId, 'Request Deleted', "Pending blood request {$requestCode} was deleted by admin.", 'REMINDER');
                }
            }
        }

        header('Location: /BloodConnect/public/admin/blood-requests?deleted=1');
        exit;
    }
}
