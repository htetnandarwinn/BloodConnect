<?php

namespace App\BloodRequest\Domain\Repository;

interface BloodRequestRepositoryInterface
{
    public function findById(int $id);
    public function create(array $data);
}
