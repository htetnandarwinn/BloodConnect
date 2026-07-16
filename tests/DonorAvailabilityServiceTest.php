<?php

require __DIR__ . '/../vendor/autoload.php';

use App\Donor\Domain\Service\DonorDonationEligibilityService;

function assertTrue(bool $condition, string $message): void
{
    if (!$condition) {
        fwrite(STDERR, "FAILED: $message\n");
        exit(1);
    }
}

$service = new DonorDonationEligibilityService();

$recent = $service->evaluate(date('Y-m-d', strtotime('-1 month')));
assertTrue($recent['is_available'] === false, 'Donors should be unavailable within 3 months of their last donation');
assertTrue($recent['next_eligible_date'] !== '', 'Recent donors should receive a next eligible date');

$old = $service->evaluate(date('Y-m-d', strtotime('-4 months')));
assertTrue($old['is_available'] === true, 'Donors should be available after 3 months from the last donation');
assertTrue($old['next_eligible_date'] === '', 'Available donors should not receive a next eligible date');

$none = $service->evaluate('');
assertTrue($none['is_available'] === true, 'Donors without a last donation should be available');

echo "Donor availability tests passed\n";
