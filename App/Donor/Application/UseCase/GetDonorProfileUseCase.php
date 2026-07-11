<?php

namespace App\Donor\Application\UseCase;

use App\Donor\Domain\Repository\DonorRepositoryInterface;
use App\BloodRequest\Domain\Repository\BloodRequestRepositoryInterface;
use App\Shared\Infrastructure\Persistence\MasterDataRepository;

class GetDonorProfileUseCase
{
    public function __construct(
        private DonorRepositoryInterface $donorRepo,
        private BloodRequestRepositoryInterface $bloodRequestRepo,
        private MasterDataRepository $masterRepo
    ) {}

    public function execute(int $userId): array
    {
        $donor = $this->donorRepo->findById($userId);
        $bloodGroup = trim((string)($donor['blood_group'] ?? ''));

        $acceptedStatus = $this->masterRepo->getId('REQUEST_STATUS', 'ACCEPTED') ?? 8;
        $acceptedRequests = $this->bloodRequestRepo->findAcceptedRequestsForDonor($userId, $acceptedStatus);
        $lastDonationDate = !empty($acceptedRequests[0]['created_at']) ? (string)$acceptedRequests[0]['created_at'] : '';

        $eligibilityService = new DonorDonationEligibilityService();
        $availabilityState = $this->donorRepo->syncAvailabilityStatus($userId);
        $eligibility = $eligibilityService->evaluate($lastDonationDate, $availabilityState['next_available_date']);

        return [
            'donor' => $donor,
            'blood_group' => $bloodGroup,
            'availability_state' => $availabilityState,
            'eligibility' => $eligibility,
            'last_donation_date' => $lastDonationDate,
        ];
    }
}
