<?php

namespace App\Donation\Application\UseCase;

use App\Donation\Domain\Repository\DonationRepositoryInterface;

class CreateDonationRecordUseCase
{
    public function __construct(
        private DonationRepositoryInterface $donationRepo
    ) {}

    public function execute(int $requestId, int $donorId, int $statusId, string $remarks = ''): array
    {
        $data = [
            'request_id'    => $requestId,
            'donor_id'      => $donorId,
            'donation_date' => date('Y-m-d'),
            'status'        => $statusId,
            'remarks'       => $remarks ?: 'Donation recorded',
        ];

        $saved = $this->donationRepo->create($data);
        if (!$saved) {
            return ['success' => false, 'error' => 'Failed to create donation record.'];
        }

        return ['success' => true];
    }
}
