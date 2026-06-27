<?php

namespace App\Donor\Domain\Repository;

interface DonorRepositoryInterface
{
    public function findById(int $id);
    public function search(array $criteria);
}
