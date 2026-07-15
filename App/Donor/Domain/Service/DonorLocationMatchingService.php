<?php

namespace App\Donor\Domain\Service;

use App\BloodRequest\Domain\Repository\BloodRequestRepositoryInterface;

class DonorLocationMatchingService
{
    public function __construct(
        private BloodRequestRepositoryInterface $bloodRequestRepo
    ) {}

    public function findMatches(string $bloodGroup, ?string $township, ?string $stateRegion): array
    {
        $townshipMatches = [];
        $regionMatches = [];
        $allMatches = [];

        if ($township !== null && $township !== '') {
            $townshipMatches = $this->bloodRequestRepo->findDonorsByBloodGroupAndLocation(
                $bloodGroup, $township, null
            );
        }

        if (empty($townshipMatches) && $stateRegion !== null && $stateRegion !== '') {
            $regionMatches = $this->bloodRequestRepo->findDonorsByBloodGroupAndLocation(
                $bloodGroup, null, $stateRegion
            );
        }

        if (empty($townshipMatches) && empty($regionMatches)) {
            $allMatches = $this->bloodRequestRepo->findDonorsByBloodGroupAndLocation(
                $bloodGroup, null, null
            );
        }

        return [
            'tier' => !empty($townshipMatches) ? 'township'
                   : (!empty($regionMatches) ? 'region'
                   : (!empty($allMatches) ? 'all' : 'none')),
            'township_matches' => $townshipMatches,
            'region_matches'   => $regionMatches,
            'all_matches'      => $allMatches,
        ];
    }
}
