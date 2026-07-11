<?php

namespace App\Donation\Application\UseCase;

use App\BloodRequest\Domain\Repository\BloodRequestRepositoryInterface;
use App\Donation\Domain\Repository\DonationRepositoryInterface;
use App\Shared\Infrastructure\Persistence\MasterDataRepository;

class ConfirmDonationUseCase
{
    public function __construct(
        private BloodRequestRepositoryInterface $bloodRequestRepo,
        private DonationRepositoryInterface $donationRepo,
        private MasterDataRepository $masterRepo
    ) {}

    public function complete(int $requestId): array
    {
        $request = $this->bloodRequestRepo->findById($requestId);
        if (!$request) {
            return ['success' => false, 'error' => 'Blood request not found.'];
        }

        $completedStatus = $this->masterRepo->getId('REQUEST_STATUS', 'COMPLETED');
        if (!$completedStatus) {
            return ['success' => false, 'error' => 'Completed status not found in master data.'];
        }

        $donorId = (int)($request['donor_id'] ?? 0);
        if ($donorId <= 0) {
            return ['success' => false, 'error' => 'No donor assigned to this request.'];
        }

        $db = \App\Shared\Infrastructure\Database\Database::getConnection();
        $stmt = $db->prepare("UPDATE blood_requests SET status = ? WHERE request_id = ?");
        $stmt->execute([$completedStatus, $requestId]);

        $this->donationRepo->updateStatusByRequestId($requestId, (int)$completedStatus);

        return ['success' => true];
    }
}
