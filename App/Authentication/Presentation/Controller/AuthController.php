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
use App\Shared\Helpers\Permission;
use App\Shared\Infrastructure\Mail\EmailService;
use App\Shared\Infrastructure\Persistence\PermissionRepository;

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

    public function showForgotPassword()
    {
        Session::start();
        Session::remove('reset_email');
        Session::remove('reset_verified');
        View::render('forgot-password');
    }

    public function sendPasswordResetOtp()
    {
        Session::start();

        $email = trim($_POST['email'] ?? '');

        if ($email === '' || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $this->setFlash(
                ['email' => 'Please enter a valid email address.'],
                ['email' => $email]
            );
            $this->redirect('/forgot-password');
        }

        $repo = new AuthRepository();
        $user = $repo->findByEmail($email);

        if (!$user) {
            $this->setFlash(
                ['form' => 'If that account exists, a reset code has been sent.'],
                ['email' => $email]
            );
            $this->redirect('/forgot-password');
        }

        $otp = random_int(100000, 999999);
        $expiresAt = date('Y-m-d H:i:s', strtotime('+10 minutes'));

        $repo->updateVerificationCode($email, $otp, $expiresAt);

        $emailService = new EmailService();
        $emailService->sendPasswordResetOtp($email, $otp);

        Session::set('reset_email', $email);
        Session::set('reset_verified', false);

        $this->setFlash([], ['email' => $email], 'A password reset code has been sent to your email.');
        $this->redirect('/forgot-password/verify');
    }

    public function showForgotPasswordOtp()
    {
        Session::start();

        if (!Session::get('reset_email')) {
            $this->redirect('/forgot-password');
        }

        View::render('forgot-password-otp');
    }

    public function verifyForgotPasswordOtp()
    {
        Session::start();

        $email = Session::get('reset_email');
        $code = trim($_POST['code'] ?? '');

        if (!$email || $code === '') {
            $this->setFlash(['form' => 'Please enter the OTP code.']);
            $this->redirect('/forgot-password/verify');
        }

        $repo = new AuthRepository();
        $user = $repo->findByEmail($email);

        if (!$user) {
            $this->setFlash(['form' => 'We could not find that account.']);
            $this->redirect('/forgot-password');
        }

        if (empty($user['verification_expires_at']) || strtotime($user['verification_expires_at']) < time()) {
            $this->setFlash(['form' => 'The OTP has expired. Please request a new one.']);
            $this->redirect('/forgot-password');
        }

        if ((string)($user['verification_code'] ?? '') !== $code) {
            $this->setFlash(['form' => 'Invalid OTP code. Please try again.']);
            $this->redirect('/forgot-password/verify');
        }

        Session::set('reset_verified', true);
        $this->setFlash([], [], 'OTP verified. Please set a new password.');
        $this->redirect('/forgot-password/reset');
    }

    public function showResetPasswordForm()
    {
        Session::start();

        if (!Session::get('reset_verified') || !Session::get('reset_email')) {
            $this->redirect('/forgot-password');
        }

        View::render('reset-password');
    }

    public function resetPassword()
    {
        Session::start();

        $email = Session::get('reset_email');

        if (!Session::get('reset_verified') || !$email) {
            $this->redirect('/forgot-password');
        }

        $password = $_POST['password'] ?? '';
        $confirmPassword = $_POST['confirm_password'] ?? '';

        if ($password === '' || $password !== $confirmPassword) {
            $this->setFlash(['form' => 'Passwords must match and cannot be empty.']);
            $this->redirect('/forgot-password/reset');
        }

        $repo = new AuthRepository();
        $repo->updatePassword($email, password_hash($password, PASSWORD_BCRYPT));
        $repo->clearVerificationCode($email);

        Session::remove('reset_email');
        Session::remove('reset_verified');

        $this->setFlash([], [], 'Your password has been updated successfully. Please log in.');
        $this->redirect('/login');
    }

    // ================= REGISTER =================
    public function registerPatient()
    {
        Session::start();

        try {

            $request = new RegisterPatientRequest();
            $data = $request->validate($_POST);

            $role = $data['role'] ?? 'patient';

            $userTypeId = match ($role) {
                'donor' => 2,
                'patient' => 3,
                default => 3,
            };

            $statusId = 3;

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

            $useCase = new RegisterPatientUseCase(
                new AuthRepository(),
                new EmailService()
            );

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
        } catch (\DomainException $e) {

            $this->setFlash(
                ['form' => $e->getMessage()],
                $_POST
            );

            $this->redirect('/register');
        } catch (\Exception $e) {

            echo "<pre>";
            echo $e->getMessage();
            echo "\n\n";
            print_r($e->getTrace());
            die();
        }
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
            // ==============================
            // EMAIL VERIFIED CHECK
            // Admin (user_type_id = 1) can log in without verification
            // ==============================
            if (
                (int)$user['is_verified'] === 0 &&
                (int)$user['user_type_id'] !== 1
            ) {
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

            $repo = new \App\Authentication\Infrastructure\Persistence\AuthRepository();
            $permissions = $repo->getPermissionsByUserType(
                (int)$user['user_type_id']
            );

            Session::set('permissions', $permissions);

            $logger = new \App\Shared\Infrastructure\Activity\ActivityLogger();

            $logger->log(
                $user['user_id'],
                $user['username'],
                'USER_LOGIN',
                $user['username'] . ' logged in to system',
                'info'
            );

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

    private function authGuard(): void
    {
        Session::start();

        if (!Session::get('user')) {
            $this->redirect('/login');
        }
    }

    public function roles(): void
    {
        $this->authGuard();

        if (!Permission::can('permission.manage')) {
            $this->redirect('/login');
        }

        ob_start();
        require __DIR__ . '/../View/roles_permissions.php';
        $content = ob_get_clean();

        require __DIR__ . '/../Layout/adminApp.php';
    }
}
