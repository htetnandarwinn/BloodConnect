<?php

namespace App\Admin\Application\UseCase;

use App\Donor\Domain\Repository\DonorRepositoryInterface;
use App\User\Domain\Repository\UserRepositoryInterface;
use App\Shared\Infrastructure\Activity\ActivityLogger;

class ManageDonorsUseCase
{
    public function __construct(
        private DonorRepositoryInterface $donorRepo,
        private UserRepositoryInterface $userRepo,
        private ActivityLogger $activityLogger
    ) {}

    public function getAllDonors(): array
    {
        return $this->userRepo->findAll();
    }

    public function getDonorById(int $id)
    {
        return $this->donorRepo->findById($id);
    }

    public function disableDonor(int $id, ?int $adminId = null, ?string $adminName = null): array
    {
        $donor = $this->donorRepo->findById($id);
        if (!$donor) {
            return ['success' => false, 'error' => 'Donor not found.'];
        }

        $this->userRepo->update($id, ['is_active' => 0]);

        $this->activityLogger->log(
            $adminId,
            $adminName,
            'DONOR_DISABLED',
            "Admin disabled donor {$donor['username']} (ID: {$id})"
        );

        return ['success' => true];
    }
}
