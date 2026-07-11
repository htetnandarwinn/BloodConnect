<?php

namespace App\BloodRequest\Application\UseCase;

use App\BloodRequest\Domain\Repository\BloodRequestRepositoryInterface;
use App\Donation\Domain\Repository\DonationRepositoryInterface;
use App\Notification\Domain\Repository\NotificationRepositoryInterface;
use App\User\Domain\Repository\UserRepositoryInterface;
use App\Shared\Infrastructure\Persistence\MasterDataRepository;

class CompleteBloodRequestUseCase
{
    public function __construct(
        private BloodRequestRepositoryInterface $bloodRequestRepo,
        private DonationRepositoryInterface $donationRepo,
        private NotificationRepositoryInterface $notificationRepo,
        private UserRepositoryInterface $userRepo,
        private MasterDataRepository $masterRepo
    ) {}

    public function execute(int $requestId): array
    {
        $request = $this->bloodRequestRepo->findById($requestId);
        if (!$request) {
            return ['success' => false, 'error' => 'Blood request not found.'];
        }

        $completedStatus = $this->masterRepo->getId('REQUEST_STATUS', 'COMPLETED') ?? 9;
        $donorId = (int)($request['donor_id'] ?? 0);
        if ($donorId <= 0) {
            return ['success' => false, 'error' => 'No donor assigned to this request.'];
        }

        $db = \App\Shared\Infrastructure\Database\Database::getConnection();
        $stmt = $db->prepare("UPDATE blood_requests SET status = ? WHERE request_id = ?");
        $stmt->execute([$completedStatus, $requestId]);

        $this->donationRepo->updateStatusByRequestId($requestId, $completedStatus);

        $donor = $this->userRepo->findById($donorId);
        $patient = $this->userRepo->findById((int)($request['patient_id'] ?? 0));

        $admins = $this->notificationRepo->getAdmins();
        foreach ($admins as $admin) {
            $this->notificationRepo->create(
                (int)$admin['user_id'],
                'Blood Request Completed',
                sprintf('Blood request %s has been completed.', $request['request_code']),
                'REQUEST'
            );
        }

        if ($donor) {
            $this->notificationRepo->create(
                $donorId,
                'Donation Completed',
                sprintf('Your donation for request %s has been confirmed. Thank you!', $request['request_code']),
                'REQUEST'
            );
        }

        if ($patient) {
            $this->notificationRepo->create(
                (int)$patient['user_id'],
                'Request Completed',
                sprintf('Your blood request %s has been completed.', $request['request_code']),
                'REQUEST'
            );
        }

        return ['success' => true];
    }
}
