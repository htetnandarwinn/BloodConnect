<?php

namespace App\Admin\Presentation\Controller;

use App\Admin\Application\UseCase\ManageDonorsUseCase;

class AdminDonorController
{
    public function __construct(
        private ManageDonorsUseCase $manageDonorsUseCase
    ) {}

    public function donorManagement(): void
    {
        $donors = $this->manageDonorsUseCase->getAllDonors();

        ob_start();
        require __DIR__ . '/../View/donor_management.php';
        $content = ob_get_clean();
        require __DIR__ . '/../Layout/adminApp.php';
    }
}
