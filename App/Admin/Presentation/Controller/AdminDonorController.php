<?php

namespace App\Admin\Presentation\Controller;

class AdminDonorController
{
    public function donorManagement(): void
    {
        ob_start();
        require __DIR__ . '/../View/donor_management.php';
        $content = ob_get_clean();
        require __DIR__ . '/../Layout/adminApp.php';
    }
}
