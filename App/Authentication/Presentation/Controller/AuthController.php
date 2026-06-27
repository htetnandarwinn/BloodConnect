<?php

namespace App\Authentication\Presentation\Controller;

require_once __DIR__ . '/../../../Shared/Helpers/Session.php';
require_once __DIR__ . '/../../Application/UseCase/LoginUseCase.php';
require_once __DIR__ . '/../../Application/UseCase/RegisterPatientUseCase.php';
require_once __DIR__ . '/../../Application/UseCase/RegisterDonorUseCase.php';
require_once __DIR__ . '/../../Application/UseCase/LogoutUseCase.php';

use App\Shared\Helpers\Session;
use App\Authentication\Application\UseCase\LoginUseCase;
use App\Authentication\Application\UseCase\RegisterPatientUseCase;
use App\Authentication\Application\UseCase\RegisterDonorUseCase;
use App\Authentication\Application\UseCase\LogoutUseCase;

class AuthController
{
    private function getBasePath(): string
    {
        $scriptDir = str_replace('\\', '/', dirname($_SERVER['SCRIPT_NAME']));
        if ($scriptDir === '/' || $scriptDir === '\\') {
            return '';
        }

        return rtrim($scriptDir, '/');
    }

    private function redirect(string $path): void
    {
        $basePath = $this->getBasePath();
        header('Location: ' . $basePath . $path);
        exit;
    }

    private function setFlash(array $errors = [], array $old = [], string $success = ''): void
    {
        Session::start();

        if (!empty($errors)) {
            $_SESSION['errors'] = $errors;
        }

        if (!empty($old)) {
            $_SESSION['old'] = $old;
        }

        if ($success !== '') {
            $_SESSION['success'] = $success;
        }
    }

    public function login()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('/login');
        }

        $login = trim($_POST['login'] ?? '');
        $password = $_POST['password'] ?? '';
        $errors = [];

        if ($login === '') {
            $errors[] = 'Email or username is required';
        }

        if ($password === '') {
            $errors[] = 'Password is required';
        }

        if (!empty($errors)) {
            $this->setFlash($errors, ['login' => $login]);
            $this->redirect('/login');
        }

        $useCase = new LoginUseCase();
        $user = $useCase->execute(['login' => $login, 'password' => $password]);

        if ($user) {
            Session::start();
            $_SESSION['user_id'] = $user['user_id'] ?? $user['id'] ?? null;
            $_SESSION['role'] = $user['role'] ?? 'user';
            $_SESSION['name'] = $user['name'] ?: ($user['username'] ?: ($user['email'] ?? ''));

            $role = $_SESSION['role'];
            if ($role === 'admin') {
                $this->redirect('/admin/dashboard');
            } elseif ($role === 'donor') {
                $this->redirect('/donor/dashboard');
            } else {
                $this->redirect('/user/dashboard');
            }
        }

        $this->setFlash(['Invalid email or username or password'], ['login' => $login]);
        $this->redirect('/login');
    }

    public function registerPatient()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('/register');
        }

        $username = trim($_POST['username'] ?? '');
        $email = trim($_POST['email'] ?? '');
        $phone = trim($_POST['phone'] ?? '');
        $password = $_POST['password'] ?? '';
        $confirmPassword = $_POST['confirm_password'] ?? '';
        $errors = [];

        if ($username === '') {
            $errors[] = 'Username is required';
        }

        if ($email === '') {
            $errors[] = 'Email is required';
        } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors[] = 'Invalid Email Format';
        }

        if ($phone === '') {
            $errors[] = 'Phone Number is required';
        } elseif (!preg_match('/^\d{11}$/', $phone)) {
            $errors[] = 'Phone Number must be exactly 11 digits';
        }

        if ($password === '') {
            $errors[] = 'Password is required';
        } elseif (strlen($password) < 8) {
            $errors[] = 'Password must be at least 8 characters';
        }

        if ($confirmPassword === '') {
            $errors[] = 'Confirm Password is required';
        } elseif ($password !== $confirmPassword) {
            $errors[] = 'Passwords do not match';
        }

        if (!empty($errors)) {
            $this->setFlash($errors, [
                'username' => $username,
                'email' => $email,
                'phone' => $phone,
            ]);
            $this->redirect('/register');
        }

        $data = [
            'name' => $username,
            'username' => $username,
            'email' => $email,
            'phone' => $phone,
            'password' => $password,
            'role' => 'patient',
        ];

        $useCase = new RegisterPatientUseCase();
        $userId = $useCase->execute($data);

        if ($userId === false) {
            $this->setFlash(['Email is already registered'], [
                'username' => $username,
                'email' => $email,
                'phone' => $phone,
            ]);
            $this->redirect('/register');
        }

        $this->setFlash([], [], 'Registration successful. Please log in with your credentials.');
        $this->redirect('/login');
    }

    public function registerDonor()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('/donor/register');
        }

        $name = trim($_POST['name'] ?? '');
        $phone = trim($_POST['phone'] ?? '');
        $email = trim($_POST['email'] ?? '');
        $address = trim($_POST['address'] ?? '');
        $bloodGroup = $_POST['blood_group'] ?? '';
        $password = $_POST['password'] ?? '';
        $confirmPassword = $_POST['confirm_password'] ?? '';
        $errors = [];

        if ($name === '') {
            $errors[] = 'Full Name is required';
        }

        if ($phone === '') {
            $errors[] = 'Phone Number is required';
        } elseif (!preg_match('/^\d{11}$/', $phone)) {
            $errors[] = 'Phone Number must be exactly 11 digits';
        }

        if ($email === '') {
            $errors[] = 'Email is required';
        } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors[] = 'Invalid Email Format';
        }

        if ($address === '') {
            $errors[] = 'Address is required';
        }

        if ($bloodGroup === '') {
            $errors[] = 'Blood Group is required';
        }

        if ($password === '') {
            $errors[] = 'Password is required';
        } elseif (strlen($password) < 8) {
            $errors[] = 'Password must be at least 8 characters';
        }

        if ($confirmPassword === '') {
            $errors[] = 'Confirm Password is required';
        } elseif ($password !== $confirmPassword) {
            $errors[] = 'Passwords do not match';
        }

        if (!empty($errors)) {
            $this->setFlash($errors, [
                'name' => $name,
                'phone' => $phone,
                'email' => $email,
                'address' => $address,
                'blood_group' => $bloodGroup,
            ]);
            $this->redirect('/donor/register');
        }

        $data = [
            'name' => $name,
            'dob' => $_POST['dob'] ?? null,
            'email' => $email,
            'phone' => $phone,
            'blood_group' => $bloodGroup,
            'gender' => $_POST['gender'] ?? null,
            'address' => $address,
            'weight' => $_POST['weight'] ?? null,
            'last_donation_date' => $_POST['last_donation_date'] ?? null,
            'password' => $_POST['password'] ?? null,
        ];

        $useCase = new RegisterDonorUseCase();
        $userId = $useCase->execute($data);

        if ($userId === false) {
            $this->setFlash(['Email is already registered'], [
                'name' => $name,
                'phone' => $phone,
                'email' => $email,
                'address' => $address,
                'blood_group' => $bloodGroup,
            ]);
            $this->redirect('/donor/register');
        }

        $this->setFlash([], [], 'Donor registration successful. Please log in with your credentials.');
        $this->redirect('/login');
    }

    public function logout()
    {
        $useCase = new LogoutUseCase();
        $useCase->execute();

        $this->redirect('/');
    }
}
