<?php

namespace App\BloodRequest\Application\UseCase;

use App\BloodRequest\Domain\Repository\BloodRequestRepositoryInterface;

class DeclineBloodRequestUseCase
{
    public function __construct(
        private BloodRequestRepositoryInterface $bloodRequestRepo
    ) {}

    public function execute(int $requestId, int $donorId): array
    {
        $updated = $this->bloodRequestRepo->updateDonorDecision($requestId, $donorId, 10);
        if (!$updated) {
            return ['success' => false, 'error' => 'Failed to decline request.'];
        }
        return ['success' => true];
    }
}
