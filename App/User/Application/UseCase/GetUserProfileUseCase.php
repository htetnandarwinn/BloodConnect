<?php

namespace App\User\Application\UseCase;

use App\User\Domain\Repository\UserRepositoryInterface;

class GetUserProfileUseCase
{
    public function __construct(
        private UserRepositoryInterface $userRepo
    ) {}

    public function execute(int $userId): ?array
    {
        return $this->userRepo->findById($userId);
    }
}
