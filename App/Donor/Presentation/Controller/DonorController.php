<?php

namespace App\Donor\Presentation\Controller;

use App\Shared\Presentation\View\View;

class DonorController
{
    public function donor_dashboard()
    {
        return View::render('donor_dashboard');
    }
}
