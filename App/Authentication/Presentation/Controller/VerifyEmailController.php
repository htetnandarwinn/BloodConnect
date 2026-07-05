<?php

namespace App\Authentication\Presentation\Controller;

use App\Shared\Helpers\Session;
use App\Authentication\Infrastructure\Persistence\AuthRepository;

class VerifyEmailController
{
    public function show()
    {
        return \App\Authentication\Presentation\View\View::render('verify-email');
    }

    public function verify()
    {
        Session::start();

        $email = Session::get('verify_email');
        $code = $_POST['code'] ?? null;

        if (!$email || !$code) {
            $_SESSION['errors']['form'] = "Invalid request.";
            $this->redirect('/verify-email');
        }

        $repo = new AuthRepository();
        $user = $repo->findByEmail($email);

        if (!$user) {
            $_SESSION['errors']['form'] = "User not found.";
            $this->redirect('/verify-email');
        }

        // ❌ expired check
        if (strtotime($user['verification_expires_at']) < time()) {
            $_SESSION['errors']['form'] = "Code expired. Please resend.";
            $this->redirect('/verify-email');
        }

        // ❌ wrong code
        if ($user['verification_code'] != $code) {
            $_SESSION['errors']['form'] = "Invalid code.";
            $this->redirect('/verify-email');
        }

        // ✅ success → verify user
        $verified = false;
        foreach (
            [
                'markAsVerified' => [$user['user_id']],
                'markVerified' => [$user['user_id']],
                'verifyUser' => [$user['user_id']],
                'verify' => [$user['user_id']],
                'verifyEmail' => [$email],
            ] as $method => $args
        ) {
            if (method_exists($repo, $method)) {
                $repo->{$method}(...$args);
                $verified = true;
                break;
            }
        }

        if (!$verified) {
            throw new \RuntimeException('Unable to verify user account.');
        }

        $_SESSION['success'] = "Email verified successfully!";
        unset($_SESSION['verify_email']);

        $this->redirect('/login');
    }

    public function resend()
    {
        Session::start();

        $email = Session::get('verify_email');

        if (!$email) {
            $this->redirect('/register');
        }

        $repo = new AuthRepository();

        $code = rand(100000, 999999);
        $expires = date('Y-m-d H:i:s', strtotime('+10 minutes'));

        // Attempt to update verification code using a repository method that may vary
        $updateMethods = [
            'updateVerificationCode',
            'setVerificationCode',
            'saveVerificationCode',
            'updateVerification',
            'setVerification',
        ];

        $updated = false;
        foreach ($updateMethods as $m) {
            if (method_exists($repo, $m)) {
                // call whichever method exists on the repository
                // some implementations expect ($email, $code, $expires) others may expect ($code, $expires, $email)
                try {
                    $repo->{$m}($email, $code, $expires);
                } catch (\ArgumentCountError $e) {
                    // try alternate argument order
                    $repo->{$m}($code, $expires, $email);
                }
                $updated = true;
                break;
            }
        }

        if (! $updated) {
            throw new \RuntimeException('Unable to update verification code: repository method not found.');
        }

        // send email again (PHPMailer)
        $this->sendEmail($email, $code);

        $_SESSION['success'] = "New code sent!";
        $this->redirect('/verify-email');
    }

    private function sendEmail($email, $code)
    {
        $emailService = new \App\Shared\Infrastructure\Mail\EmailService();
        $emailService->sendOtp($email, $code);
    }

    private function redirect(string $path): void
    {
        $basePath = '/BloodConnect/public';
        $normalizedPath = '/' . ltrim($path, '/');
        header('Location: ' . $basePath . $normalizedPath);
        exit;
    }
}
