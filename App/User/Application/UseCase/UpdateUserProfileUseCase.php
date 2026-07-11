<?php

namespace App\User\Application\UseCase;

use App\User\Domain\Repository\UserRepositoryInterface;
use App\Shared\Infrastructure\Activity\ActivityLogger;

class UpdateUserProfileUseCase
{
    public function __construct(
        private UserRepositoryInterface $userRepo,
        private ActivityLogger $activityLogger
    ) {}

    public function execute(int $userId, array $data): array
    {
        $updated = $this->userRepo->update($userId, $data);
        if (!$updated) {
            return ['success' => false, 'error' => 'Update failed.'];
        }

        $this->activityLogger->log(
            $userId,
            $data['username'] ?? null,
            'PROFILE_UPDATED',
            "Patient updated their profile"
        );

        return ['success' => true];
    }
}
