<?php

namespace App\Authentication\Presentation\Controller;

use App\Shared\Helpers\Session;
use App\Authentication\Application\UseCase\LoginUseCase;
use App\Authentication\Application\UseCase\RegisterPatientUseCase;
use App\Authentication\Application\UseCase\LogoutUseCase;
use App\Authentication\Presentation\View\View;
use App\Authentication\Application\DTO\RegisterPatientDTO;
use App\Authentication\Infrastructure\Persistence\AuthRepository;
use App\Authentication\Presentation\Request\RegisterPatientRequest;
use App\Authentication\Presentation\Request\LoginRequest;
use App\Shared\Infrastructure\Mail\EmailService;

class AuthController
{
    // ================= VIEW =================

    public function showRegister()
    {
        View::render('register');
    }

    public function showLogin()
    {
        View::render('login');
    }

    // ================= REGISTER =================
    public function registerPatient()
    {
        Session::start();

        $request = new RegisterPatientRequest();
        $data = $request->validate($_POST);

        $role = $data['role'] ?? 'patient';

        $userTypeId = match ($role) {
            'donor' => 2,
            'patient' => 3,
            default => 3,
        };

        // ✅ HARD CODED STATUS (PENDING)
        $statusId = 3;

        // OTP logic (allowed in controller)
        $otp = random_int(100000, 999999);
        $expiresAt = date('Y-m-d H:i:s', strtotime('+10 minutes'));

        $dto = new RegisterPatientDTO(
            $data['username'],
            $data['email'],
            $data['phone'] ?? null,
            $data['password'],
            $data['blood_group'] ?? null,
            $data['address'] ?? null,
            $role
        );

        $useCase = new RegisterPatientUseCase(new AuthRepository(), new EmailService());

        $userId = $useCase->execute(
            $dto,
            $userTypeId,
            $statusId,
            $otp,
            $expiresAt
        );

        Session::set('verify_email', $data['email']);
        Session::set('verify_user_id', $userId);

        $this->redirect('/verify-email');
    }

    // ================= LOGIN =================

    public function login()
    {
        Session::start();

        try {

            $request = new LoginRequest();
            $data = $request->validate($_POST);

            $useCase = new LoginUseCase();

            $result = $useCase->execute($data);

            if (!$result['success']) {

                $this->setFlash(
                    $result['errors'],
                    [
                        'login' => $data['login'] ?? ''
                    ]
                );

                $this->redirect('/login');
            }

            $user = $result['user'];

            // ==============================
            // ❌ CHECK: ACCOUNT ACTIVE
            // ==============================
            if ((int)$user['is_active'] === 0) {
                $this->setFlash(
                    ['form' => 'Your account has been disabled.'],
                    ['login' => $data['login'] ?? '']
                );
                $this->redirect('/login');
            }

            // ==============================
            // ❌ CHECK: EMAIL VERIFIED
            // ==============================
            if ((int)$user['is_verified'] === 0) {
                $this->setFlash(
                    ['form' => 'Please verify your email first.'],
                    ['login' => $data['login'] ?? '']
                );
                $this->redirect('/login');
            }

            // ==========================
            // SAVE LOGIN SESSION
            // ==========================
            Session::set('user', $user);
            Session::set('user_id', $user['user_id']);
            Session::set('username', $user['username']);
            Session::set('email', $user['email']);
            Session::set('user_type_id', $user['user_type_id']);

            // ==============================
            // OPTIONAL: mark user as online
            // ==============================
            $repo = new \App\Authentication\Infrastructure\Persistence\AuthRepository();
            // setLoginStatus may not exist in all repository implementations
            $method = 'setLoginStatus';
            if (method_exists($repo, $method)) {
                // call dynamically to avoid static analysis errors about undefined method
                $repo->{$method}($user['user_id'], 1);
            }

            // ==========================
            // REDIRECT BY ROLE
            // ==========================
            switch ($user['user_type_id']) {

                case 1:
                    $this->redirect('/admin/dashboard');
                    break;

                case 2:
                    $this->redirect('/donor/dashboard');
                    break;

                case 3:
                    $this->redirect('/patient/dashboard');
                    break;

                default:

                    unset($_SESSION['user']);
                    unset($_SESSION['user_id']);
                    unset($_SESSION['username']);
                    unset($_SESSION['email']);
                    unset($_SESSION['user_type_id']);

                    $this->setFlash([
                        'form' => 'Unknown user type.'
                    ]);

                    $this->redirect('/login');
            }
        } catch (\DomainException $e) {

            $this->setFlash(
                ['form' => $e->getMessage()],
                ['login' => $_POST['login'] ?? '']
            );

            $this->redirect('/login');
        } catch (\Exception $e) {

            $this->setFlash(
                ['form' => 'Something went wrong. Please try again.'],
                ['login' => $_POST['login'] ?? '']
            );

            $this->redirect('/login');
        }
    }

    // ================= LOGOUT =================

    public function logout()
    {
        $useCase = new LogoutUseCase();
        $useCase->execute();

        $this->redirect('/');
    }

    // ================= HELPERS =================

    private function redirect(string $path): void
    {
        $basePath = '/BloodConnect/public';
        $normalizedPath = '/' . ltrim($path, '/');
        header('Location: ' . $basePath . $normalizedPath);
        exit;
    }

    private function setFlash(array $errors = [], array $old = [], string $success = ''): void
    {
        Session::start();

        $_SESSION['errors'] = $errors;
        $_SESSION['old'] = $old;

        if ($success !== '') {
            $_SESSION['success'] = $success;
        }
    }
}
