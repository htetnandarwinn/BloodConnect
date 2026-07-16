<?php

namespace App\BloodRequest\Application\UseCase;

use App\BloodRequest\Domain\Repository\BloodRequestRepositoryInterface;
use App\Donor\Domain\Repository\DonorRepositoryInterface;
use App\Donation\Domain\Repository\DonationRepositoryInterface;
use App\Donor\Domain\Service\DonorDonationEligibilityService;
use App\Donor\Domain\Service\DonorEligibilityService;
use App\Notification\Domain\Repository\NotificationRepositoryInterface;
use App\User\Domain\Repository\UserRepositoryInterface;
use App\Shared\Infrastructure\Persistence\MasterDataRepository;
use App\Shared\Infrastructure\Activity\ActivityLogger;

class AcceptBloodRequestUseCase
{
    public function __construct(
        private BloodRequestRepositoryInterface $bloodRequestRepo,
        private DonorRepositoryInterface $donorRepo,
        private DonationRepositoryInterface $donationRepo,
        private DonorDonationEligibilityService $eligibilityService,
        private NotificationRepositoryInterface $notificationRepo,
        private UserRepositoryInterface $userRepo,
        private MasterDataRepository $masterRepo,
        private ActivityLogger $activityLogger,
        private DonorEligibilityService $donorEligibilityService
    ) {}

    public function execute(int $requestId, int $donorId): array
    {
        $donorProfile = $this->donorRepo->getDonorDetails($donorId);
        if ($donorProfile) {
            $profileEligibility = $this->donorEligibilityService->evaluate(
                (string)($donorProfile['date_of_birth'] ?? ''),
                (string)($donorProfile['weight'] ?? '')
            );
            if (!$profileEligibility['eligible']) {
                return ['success' => false, 'error' => 'You cannot accept this request: ' . implode(', ', $profileEligibility['reasons'])];
            }
        }

        $availability = $this->donorRepo->syncAvailabilityStatus($donorId);
        $acceptedStatus = $this->masterRepo->getId('REQUEST_STATUS', 'ACCEPTED') ?? 8;

        $lastDonation = $this->bloodRequestRepo->findAcceptedRequestsForDonor($donorId, $acceptedStatus);
        $lastDonationDate = !empty($lastDonation[0]['created_at']) ? (string)$lastDonation[0]['created_at'] : '';

        $eligibility = $this->eligibilityService->evaluate($lastDonationDate, $availability['next_available_date']);
        if (!$eligibility['is_available']) {
            return ['success' => false, 'error' => 'You are not eligible to donate yet. Next eligible date: ' . $eligibility['next_eligible_date']];
        }

        $existingAccepted = $this->bloodRequestRepo->findAcceptedRequestsForDonor($donorId, $acceptedStatus);
        if (!empty($existingAccepted)) {
            return ['success' => false, 'error' => 'You cannot accept more requests while you have an active accepted request.'];
        }

        $updated = $this->bloodRequestRepo->updateDonorDecision($requestId, $donorId, $acceptedStatus);
        if (!$updated) {
            return ['success' => false, 'error' => 'Failed to accept request.'];
        }

        $nextAvailableDate = (new \DateTime('now', new \DateTimeZone('Asia/Yangon')))
            ->modify('+3 months')
            ->format('Y-m-d H:i:s');
        $this->donorRepo->saveNextAvailableDate($donorId, $nextAvailableDate);

        $this->donationRepo->create([
            'request_id'    => $requestId,
            'donor_id'      => $donorId,
            'donation_date' => date('Y-m-d'),
            'status'        => $acceptedStatus,
            'remarks'       => 'Accepted by donor'
        ]);

        $request = $this->bloodRequestRepo->findById($requestId);
        $donor = $this->userRepo->findById($donorId);
        $patient = $this->userRepo->findById((int)($request['patient_id'] ?? 0));

        $admins = $this->notificationRepo->getAdmins();
        foreach ($admins as $admin) {
            $this->notificationRepo->create(
                (int)$admin['user_id'],
                'Blood Request Accepted',
                sprintf(
                    'Blood request %s has been accepted by donor %s.',
                    $request['request_code'] ?? 'N/A',
                    $donor['username'] ?? 'Unknown donor'
                ),
                'REQUEST'
            );
        }

        if ($donor) {
            $this->notificationRepo->create(
                $donorId,
                'Blood Request Accepted',
                sprintf(
                    'You accepted blood request %s. The patient will be notified shortly.',
                    $request['request_code'] ?? 'N/A'
                ),
                'REQUEST'
            );
        }

        if ($patient) {
            $this->notificationRepo->create(
                (int)$patient['user_id'],
                'Blood Request Accepted',
                sprintf(
                    'Donor %s has accepted your blood request %s.',
                    $donor['username'] ?? 'A donor',
                    $request['request_code'] ?? 'N/A'
                ),
                'REQUEST'
            );
        }

        $this->activityLogger->log(
            $donorId,
            $donor['username'] ?? null,
            'REQUEST_ACCEPTED',
            "Donor accepted blood request {$request['request_code']} (ID: {$requestId})"
        );

        return ['success' => true];
    }
}
