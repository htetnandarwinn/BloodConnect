<?php

namespace App\Donation\Domain\Repository;

interface DonationRepositoryInterface
{
    public function create(array $data);
    public function findByDonor(int $donorId);
}
