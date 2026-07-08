<?php

namespace App\Donor\Application\UseCase;

use App\Donor\Infrastructure\Persistence\DonorRepository;

class UpdateDonorProfileUseCase
{
    public function execute(int $donorId, array $data): bool
    {
        $repo = new DonorRepository();

        return $repo->updateProfile($donorId, $data);
    }
}
