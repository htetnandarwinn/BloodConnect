<?php

namespace App\Donation\Application\UseCase;

use App\Donation\Domain\Repository\DonationRepositoryInterface;

class GetDonationHistoryUseCase
{
    public function __construct(
        private DonationRepositoryInterface $donationRepo
    ) {}

    public function execute(int $donorId): array
    {
        return $this->donationRepo->findByDonor($donorId);
    }
}
