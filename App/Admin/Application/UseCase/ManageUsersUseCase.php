<?php

namespace App\Admin\Application\UseCase;

use App\User\Domain\Repository\UserRepositoryInterface;

class ManageUsersUseCase
{
    public function __construct(
        private UserRepositoryInterface $userRepo
    ) {}

    public function getAllUsers(): array
    {
        return $this->userRepo->findAll();
    }

    public function getUserById(int $id)
    {
        return $this->userRepo->findById($id);
    }
}
