<?php

namespace App\Donor\Application\UseCase;

use App\Donor\Domain\Repository\DonorRepositoryInterface;
use App\Notification\Domain\Repository\NotificationRepositoryInterface;
use App\User\Domain\Repository\UserRepositoryInterface;
use App\Shared\Infrastructure\Activity\ActivityLogger;

class UpdateDonorProfileUseCase
{
    public function __construct(
        private DonorRepositoryInterface $donorRepo,
        private NotificationRepositoryInterface $notificationRepo,
        private UserRepositoryInterface $userRepo,
        private ActivityLogger $activityLogger
    ) {}

    public function execute(int $userId, array $data): array
    {
        $weight = trim((string)($data['weight'] ?? ''));
        if ($weight !== '') {
            if (!is_numeric($weight) || (float)$weight <= 0) {
                return ['success' => false, 'errors' => ['weight' => 'Please enter a valid weight.']];
            }
        }

        $success = $this->donorRepo->updateProfile($userId, $data);
        if (!$success) {
            return ['success' => false, 'error' => 'Update failed.'];
        }

        // Re-evaluate availability: a corrected weight (or date of birth) must
        // flip the donor back to Available when they meet eligibility again.
        $this->donorRepo->syncAvailabilityStatus($userId);

        $this->notificationRepo->create(
            $userId,
            'Profile Updated',
            'Your donor profile has been updated successfully.',
            'PROFILE_UPDATE'
        );

        $admins = $this->userRepo->getAdmins();
        foreach ($admins as $admin) {
            $this->notificationRepo->create(
                (int)$admin['user_id'],
                'Donor Profile Updated',
                sprintf('%s updated their donor profile information.', $data['username'] ?? 'A donor'),
                'PROFILE_UPDATE'
            );
        }

        $this->activityLogger->log(
            $userId,
            $data['username'] ?? null,
            'PROFILE_UPDATED',
            "Donor updated their profile"
        );

        return ['success' => true];
    }
}
