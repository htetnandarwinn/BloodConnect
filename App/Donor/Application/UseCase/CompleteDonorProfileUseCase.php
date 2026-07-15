<?php

namespace App\Donor\Application\UseCase;

use App\Donor\Domain\Repository\DonorRepositoryInterface;
use App\Donor\Domain\Service\DonorEligibilityService;
use App\Shared\Infrastructure\Activity\ActivityLogger;

class CompleteDonorProfileUseCase
{
    public function __construct(
        private DonorRepositoryInterface $donorRepo,
        private DonorEligibilityService $eligibilityService,
        private ActivityLogger $activityLogger
    ) {}

    public function execute(int $userId, string $username, array $data): array
    {
        $errors = [];

        $dateOfBirth = trim($data['date_of_birth'] ?? '');
        $weight = trim($data['weight'] ?? '');

        if ($dateOfBirth === '') {
            $errors['date_of_birth'] = 'Date of birth is required.';
        } elseif (!preg_match('/^\d{4}-\d{2}-\d{2}$/', $dateOfBirth)) {
            $errors['date_of_birth'] = 'Date of birth must be in YYYY-MM-DD format.';
        } else {
            $dob = \DateTime::createFromFormat('Y-m-d', $dateOfBirth);
            if (!$dob || $dob > new \DateTime()) {
                $errors['date_of_birth'] = 'Please enter a valid date of birth.';
            }
        }

        if ($weight === '') {
            $errors['weight'] = 'Weight is required.';
        } elseif (!is_numeric($weight) || (float)$weight <= 0) {
            $errors['weight'] = 'Please enter a valid weight.';
        }

        if (!empty($errors)) {
            return ['success' => false, 'errors' => $errors];
        }

        $donorDetails = $this->donorRepo->getDonorDetails($userId);
        $hasExistingDob = $donorDetails && !empty($donorDetails['date_of_birth']);

        $saveData = ['weight' => $weight];
        if (!$hasExistingDob) {
            $saveData['date_of_birth'] = $dateOfBirth;
        }

        $stateRegion = trim($data['state_region'] ?? '');
        $township = trim($data['township'] ?? '');
        if ($stateRegion !== '') {
            $saveData['state_region'] = $stateRegion;
        }
        if ($township !== '') {
            $saveData['township'] = $township;
        }

        $saved = $this->donorRepo->saveDonorDetails($userId, $saveData);
        if (!$saved) {
            return ['success' => false, 'errors' => ['form' => 'Failed to save donor profile.']];
        }

        $finalDob = $hasExistingDob ? $donorDetails['date_of_birth'] : $dateOfBirth;
        $eligibility = $this->eligibilityService->evaluate($finalDob, $weight);

        $this->activityLogger->log(
            $userId,
            $username,
            'DONOR_PROFILE_COMPLETED',
            "Donor profile completed (DOB: {$finalDob}, Weight: {$weight}kg)"
        );

        return [
            'success' => true,
            'eligibility' => $eligibility,
        ];
    }
}
