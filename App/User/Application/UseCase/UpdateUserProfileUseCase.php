<?php

namespace App\User\Application\UseCase;

use App\User\Domain\Repository\UserRepositoryInterface;

class UpdateUserProfileUseCase
{
    public function __construct(
        private UserRepositoryInterface $userRepo
    ) {}

    public function execute(int $userId, array $data): array
    {
        $updated = $this->userRepo->update($userId, $data);
        if (!$updated) {
            return ['success' => false, 'error' => 'Update failed.'];
        }
        return ['success' => true];
    }
}
