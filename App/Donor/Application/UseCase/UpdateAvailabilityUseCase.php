<?php

namespace App\Donor\Application\UseCase;

use App\Donor\Domain\Repository\DonorRepositoryInterface;
use App\Shared\Infrastructure\Activity\ActivityLogger;

class UpdateAvailabilityUseCase
{
    public function __construct(
        private DonorRepositoryInterface $donorRepo,
        private ActivityLogger $activityLogger
    ) {}

    public function execute(int $donorId): array
    {
        $result = $this->donorRepo->syncAvailabilityStatus($donorId);

        $this->activityLogger->log(
            $donorId,
            null,
            'AVAILABILITY_UPDATED',
            'Donor availability status synced'
        );

        return $result;
    }
}
