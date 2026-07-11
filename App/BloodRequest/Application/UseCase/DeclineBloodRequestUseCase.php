<?php

namespace App\BloodRequest\Application\UseCase;

use App\BloodRequest\Domain\Repository\BloodRequestRepositoryInterface;
use App\Shared\Infrastructure\Activity\ActivityLogger;

class DeclineBloodRequestUseCase
{
    public function __construct(
        private BloodRequestRepositoryInterface $bloodRequestRepo,
        private ActivityLogger $activityLogger
    ) {}

    public function execute(int $requestId, int $donorId): array
    {
        $updated = $this->bloodRequestRepo->updateDonorDecision($requestId, $donorId, 10);
        if (!$updated) {
            return ['success' => false, 'error' => 'Failed to decline request.'];
        }

        $this->activityLogger->log(
            $donorId,
            null,
            'REQUEST_DECLINED',
            "Donor declined blood request ID: {$requestId}"
        );

        return ['success' => true];
    }
}
