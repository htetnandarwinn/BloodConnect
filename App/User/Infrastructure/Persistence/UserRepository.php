<?php

namespace App\User\Infrastructure\Persistence;

use App\User\Domain\Repository\UserRepositoryInterface;

class UserRepository implements UserRepositoryInterface
{
    public function findById(int $id)
    {
        // TODO: fetch user
    }

    public function update(int $id, array $data)
    {
        // TODO: update user
    }
}
