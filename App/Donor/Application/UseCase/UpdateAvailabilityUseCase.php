<?php

namespace App\Donor\Application\UseCase;

use App\Donor\Domain\Repository\DonorRepositoryInterface;

class UpdateAvailabilityUseCase
{
    public function __construct(
        private DonorRepositoryInterface $donorRepo
    ) {}

    public function execute(int $donorId): array
    {
        return $this->donorRepo->syncAvailabilityStatus($donorId);
    }
}
