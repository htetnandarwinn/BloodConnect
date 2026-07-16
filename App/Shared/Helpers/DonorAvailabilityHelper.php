<?php

namespace App\Shared\Helpers;

class DonorAvailabilityHelper
{
    public const STATUS_AVAILABLE = 'AVAILABLE';
    public const STATUS_UNAVAILABLE = 'UNAVAILABLE';
    public const STATUS_INACTIVE = 'INACTIVE';

    public static function compute(
        int $isActive,
        int $available,
        ?string $nextAvailableDate,
        ?string $dateOfBirth,
        $weight
    ): string {
        if ((int)$isActive !== 1) {
            return self::STATUS_INACTIVE;
        }

        if ((int)$available === 1 || empty($nextAvailableDate)) {
            return self::STATUS_AVAILABLE;
        }

        return self::STATUS_UNAVAILABLE;
    }

    public static function isEligible(?string $dateOfBirth, $weight): bool
    {
        if (empty($dateOfBirth) || empty($weight)) {
            return false;
        }

        $dob = \DateTime::createFromFormat('Y-m-d', $dateOfBirth);
        if ($dob) {
            $age = (int)$dob->diff(new \DateTime())->y;
            if ($age < 18 || $age > 65) {
                return false;
            }
        }

        return (float)$weight >= 50;
    }

    public static function eligibilityReasons(?string $dateOfBirth, $weight): array
    {
        $reasons = [];

        if (!empty($dateOfBirth)) {
            $dob = \DateTime::createFromFormat('Y-m-d', $dateOfBirth);
            if ($dob) {
                $age = (int)$dob->diff(new \DateTime())->y;
                if ($age < 18) {
                    $reasons[] = 'Under 18';
                } elseif ($age > 65) {
                    $reasons[] = 'Over 65';
                }
            }
        }

        if (empty($weight) || (float)$weight < 50) {
            $reasons[] = 'Weight < 50kg';
        }

        return $reasons;
    }

    public static function withEligibilityOverride(string $status, ?string $dateOfBirth, $weight): string
    {
        if ($status === self::STATUS_AVAILABLE && !self::isEligible($dateOfBirth, $weight)) {
            return self::STATUS_UNAVAILABLE;
        }

        return $status;
    }
}
