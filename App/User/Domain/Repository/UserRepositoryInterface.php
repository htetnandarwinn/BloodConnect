<?php

namespace App\User\Domain\Repository;

interface UserRepositoryInterface
{
    public function findById(int $id);
    public function update(int $id, array $data);
}
