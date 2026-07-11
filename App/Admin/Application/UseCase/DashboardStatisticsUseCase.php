<?php

namespace App\Admin\Application\UseCase;

use App\User\Domain\Repository\UserRepositoryInterface;
use App\BloodRequest\Domain\Repository\BloodRequestRepositoryInterface;
use App\Donation\Domain\Repository\DonationRepositoryInterface;

class DashboardStatisticsUseCase
{
    public function __construct(
        private UserRepositoryInterface $userRepo,
        private BloodRequestRepositoryInterface $bloodRequestRepo,
        private DonationRepositoryInterface $donationRepo
    ) {}

    public function execute(): array
    {
        $users = $this->userRepo->findAll();
        $requests = $this->bloodRequestRepo->findAll();

        $totalDonors = 0;
        $totalPatients = 0;
        foreach ($users as $user) {
            $type = (int)($user['user_type_id'] ?? 0);
            if ($type === 2) $totalDonors++;
            elseif ($type === 3) $totalPatients++;
        }

        $pendingRequests = 0;
        foreach ($requests as $request) {
            if (strtolower(trim($request['status'] ?? '')) === 'pending') {
                $pendingRequests++;
            }
        }

        return [
            'totalUsers'        => count($users),
            'totalDonors'       => $totalDonors,
            'totalPatients'     => $totalPatients,
            'totalRequests'     => count($requests),
            'pendingRequests'   => $pendingRequests,
            'completedRequests' => $this->donationRepo->countSuccessfulDonations(),
            'acceptedRequests'  => $this->bloodRequestRepo->countAcceptedByDonors(),
        ];
    }
}
