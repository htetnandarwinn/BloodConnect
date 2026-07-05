<?php

namespace App\Shared\Presentation\Controller;

use App\Shared\Presentation\View\View;

class HomeController
{
    public function home()
    {
        return View::render('home');
    }

    public function about()
    {
        return View::render('about');
    }

    public function contact()
    {
        return View::render('contact');
    }

    public function search()
    {
        return View::render('search');
    }

    public function donors()
    {
        return View::render('donors');
    }
     public function donor_dashboard()
    {
        return View::render('donor-dashboard');
    }
}
