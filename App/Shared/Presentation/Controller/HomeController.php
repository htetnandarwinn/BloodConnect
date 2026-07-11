<?php

namespace App\Shared\Presentation\Controller;

use App\Shared\Presentation\View\View;
use App\Donation\Domain\Repository\DonationRepositoryInterface;
use App\User\Domain\Repository\UserRepositoryInterface;

class HomeController
{
    public function __construct(
        private DonationRepositoryInterface $donationRepo,
        private UserRepositoryInterface $userRepo
    ) {}

    public function home()
    {
        $successfulDonations = $this->donationRepo->countSuccessfulDonations();

        $users = $this->userRepo->findAll();
        $totalUsers = count($users);

        $totalDonors = 0;
        foreach ($users as $user) {
            if ((int)($user['user_type_id'] ?? 0) === 2) $totalDonors++;
        }

        return View::render('home', [
            'successful_donations' => $successfulDonations,
            'total_donors' => $totalDonors,
            'total_users' => $totalUsers,
        ]);
    }

    public function about()
    {
        return View::render('about');
    }

    public function contact()
    {
        return View::render('contact');
    }

    public function contactSend()
    {
        $name    = trim($_POST['name'] ?? '');
        $email   = trim($_POST['email'] ?? '');
        $subject = trim($_POST['subject'] ?? '');
        $message = trim($_POST['message'] ?? '');

        $errors = [];
        if ($name === '')    $errors['name']    = 'Full name is required.';
        if ($email === '' || !str_contains($email, '@')) $errors['email'] = 'A valid email is required.';
        if ($subject === '') $errors['subject'] = 'Please specify a clear subject.';
        if ($message === '') $errors['message'] = 'Message cannot be blank.';

        if (!empty($errors)) {
            $_SESSION['errors'] = $errors;
            $_SESSION['old'] = $_POST;
            header('Location: ' . ($_SERVER['HTTP_REFERER'] ?? '/contact'));
            exit;
        }

        $_SESSION['success'] = 'Your message has been received. Our team will respond within 24 hours.';
        $_SESSION['old'] = [];
        header('Location: /contact');
        exit;
    }

    public function faq()
    {
        return View::render('faq');
    }

    public function privacy()
    {
        return View::render('privacy_policy');
    }

    public function terms()
    {
        return View::render('terms_of_service');
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
