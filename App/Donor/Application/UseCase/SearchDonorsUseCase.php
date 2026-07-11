<?php

namespace App\Donor\Application\UseCase;

use App\Donor\Domain\Repository\DonorRepositoryInterface;

class SearchDonorsUseCase
{
    public function __construct(
        private DonorRepositoryInterface $donorRepo
    ) {}

    public function execute(array $criteria): array
    {
        return $this->donorRepo->search($criteria);
    }
}
