<?php

namespace App\Donor\Domain\Repository;

interface DonorRepositoryInterface
{
    public function findById(int $id);
    public function search(array $criteria);
    public function syncAvailabilityStatus(int $userId): array;
    public function saveNextAvailableDate(int $userId, string $nextAvailableDate): bool;
    public function updateProfile(int $id, array $data): bool;
    public function createDonorProfile(int $userId): bool;
}
