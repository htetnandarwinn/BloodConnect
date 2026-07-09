<?php

namespace App\Donor\Application\UseCase;

class DonorDonationEligibilityService
{
    private int $cooldownMonths = 3;

    public function evaluate(?string $lastDonationDate): array
    {
        if ($lastDonationDate === null || trim((string) $lastDonationDate) === '') {
            return [
                'is_available' => true,
                'next_eligible_date' => '',
                'message' => 'You are eligible to donate now.'
            ];
        }

        $date = strtotime((string) $lastDonationDate);

        if ($date === false) {
            return [
                'is_available' => true,
                'next_eligible_date' => '',
                'message' => 'You are eligible to donate now.'
            ];
        }

        $eligibleDate = strtotime(sprintf('+%d months', $this->cooldownMonths), $date);
        $now = time();
        $isAvailable = $now >= $eligibleDate;

        return [
            'is_available' => $isAvailable,
            'next_eligible_date' => $isAvailable ? '' : date('Y-m-d', $eligibleDate),
            'message' => $isAvailable
                ? 'You are eligible to donate now.'
                : 'You will be eligible again after the waiting period.'
        ];
    }
}
