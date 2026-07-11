<?php

namespace App\Donor\Application\UseCase;

use App\BloodRequest\Domain\Repository\BloodRequestRepositoryInterface;
use App\Shared\Infrastructure\Persistence\MasterDataRepository;

class GetDonationHistoryUseCase
{
    public function __construct(
        private BloodRequestRepositoryInterface $bloodRequestRepo,
        private MasterDataRepository $masterRepo
    ) {}

    public function execute(int $donorId): array
    {
        $acceptedStatus = $this->masterRepo->getId('REQUEST_STATUS', 'ACCEPTED') ?? 8;
        return $this->bloodRequestRepo->findAcceptedRequestsForDonor($donorId, $acceptedStatus);
    }
}
