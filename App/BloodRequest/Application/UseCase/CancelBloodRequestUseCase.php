<?php

namespace App\BloodRequest\Application\UseCase;

use App\BloodRequest\Domain\Repository\BloodRequestRepositoryInterface;
use App\Notification\Domain\Repository\NotificationRepositoryInterface;
use App\User\Domain\Repository\UserRepositoryInterface;
use App\Shared\Infrastructure\Persistence\MasterDataRepository;
use App\Shared\Infrastructure\Activity\ActivityLogger;

class CancelBloodRequestUseCase
{
    public function __construct(
        private BloodRequestRepositoryInterface $bloodRequestRepo,
        private NotificationRepositoryInterface $notificationRepo,
        private UserRepositoryInterface $userRepo,
        private MasterDataRepository $masterRepo,
        private ActivityLogger $activityLogger
    ) {}

    public function execute(int $requestId, int $patientId): array
    {
        $request = $this->bloodRequestRepo->findById($requestId);
        if (!$request) {
            return ['success' => false, 'error' => 'Blood request not found.'];
        }

        if ((int)($request['patient_id'] ?? 0) !== $patientId) {
            return ['success' => false, 'error' => 'You can only cancel your own requests.'];
        }

        $cancelledStatus = $this->masterRepo->getId('REQUEST_STATUS', 'CANCELLED') ?? 10;
        $cancelled = $this->bloodRequestRepo->cancelRequest($requestId, $patientId, $cancelledStatus);

        if (!$cancelled) {
            return ['success' => false, 'error' => 'Cannot cancel this request. Only pending requests can be cancelled.'];
        }

        $this->notificationRepo->create(
            $patientId,
            'Request Cancelled',
            'Your blood request has been cancelled.',
            'REMINDER'
        );

        $patientName = htmlspecialchars($request['patient_name'] ?? 'A patient');
        $bloodGroup = htmlspecialchars($request['blood_group_needed'] ?? '');

        $donorId = (int)($request['donor_id'] ?? 0);
        if ($donorId > 0) {
            $this->notificationRepo->create(
                $donorId,
                'Request Cancelled',
                "{$patientName} has cancelled their {$bloodGroup} blood request.",
                'REMINDER'
            );
        }

        $matchingDonors = $this->bloodRequestRepo->getMatchingDonors(
            $bloodGroup,
            $request['township'] ?? null,
            $request['state_region'] ?? null
        );
        foreach ($matchingDonors as $donor) {
            $matchedDonorId = (int)$donor['user_id'];
            if ($matchedDonorId === $donorId) {
                continue;
            }
            $this->notificationRepo->create(
                $matchedDonorId,
                'Request Cancelled',
                "{$patientName} has cancelled their {$bloodGroup} blood request.",
                'REMINDER'
            );
        }

        $admins = $this->userRepo->getAdmins();
        foreach ($admins as $admin) {
            $this->notificationRepo->create(
                (int)$admin['user_id'],
                'Request Cancelled',
                "{$patientName} has cancelled their {$bloodGroup} blood request.",
                'REMINDER'
            );
        }

        $this->activityLogger->log(
            $patientId,
            null,
            'REQUEST_CANCELLED',
            "Patient cancelled blood request {$request['request_code']} (ID: {$requestId})"
        );

        return ['success' => true];
    }
}
