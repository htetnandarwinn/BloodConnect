<?php

namespace App\Admin\Application\UseCase;

use App\Donor\Domain\Repository\DonorRepositoryInterface;
use App\User\Domain\Repository\UserRepositoryInterface;
use App\Notification\Domain\Repository\NotificationRepositoryInterface;
use App\Shared\Infrastructure\Activity\ActivityLogger;

class ManageDonorsUseCase
{
    public function __construct(
        private DonorRepositoryInterface $donorRepo,
        private UserRepositoryInterface $userRepo,
        private ActivityLogger $activityLogger,
        private NotificationRepositoryInterface $notificationRepo
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

        $this->notificationRepo->create(
            (int)$id,
            'Your Account Has Been Disabled',
            sprintf(
                'An administrator has disabled your donor account. You will no longer be able to log in or accept blood requests. If you believe this is an error, please contact support.'
            ),
            'ADMIN_ACTION'
        );

        $admins = $this->notificationRepo->getAdmins();
        foreach ($admins as $admin) {
            $adminUserId = (int)($admin['user_id'] ?? 0);
            if ($adminUserId > 0 && $adminUserId !== $adminId) {
                $this->notificationRepo->create(
                    $adminUserId,
                    'Donor Account Disabled',
                    sprintf(
                        'Admin %s disabled donor "%s" (ID: %s).',
                        $adminName ?? 'Admin',
                        $donor['username'],
                        $id
                    ),
                    'ADMIN_ACTION'
                );
            }
        }

        return ['success' => true];
    }
}
