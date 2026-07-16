<?php

namespace App\Shared\Infrastructure\Mail;

require_once __DIR__ . '/../../../../vendor/phpmailer/Exception.php';
require_once __DIR__ . '/../../../../vendor/phpmailer/SMTP.php';
require_once __DIR__ . '/../../../../vendor/phpmailer/PHPMailer.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class EmailService
{
    private string $fromAddress;
    private string $fromName;

    public function __construct()
    {
        $this->fromAddress = $this->getEnvValue('MAIL_FROM_ADDRESS', 'noreply@bloodconnect.com');
        $this->fromName = $this->getEnvValue('MAIL_FROM_NAME', 'BloodConnect');
    }

    public function sendOtp(string $toEmail, string|int $otp): bool
    {
        $mail = new PHPMailer(true);

        try {
            $host = $this->getEnvValue('MAIL_HOST');
            $username = $this->getEnvValue('MAIL_USERNAME');
            $password = $this->getEnvValue('MAIL_PASSWORD');

            if ($host && $username && $password) {
                $mail->isSMTP();
                $mail->Host = $host;
                $mail->SMTPAuth = true;
                $mail->Username = $username;
                $mail->Password = $password;
                $mail->SMTPSecure = $this->getEnvValue('MAIL_ENCRYPTION', PHPMailer::ENCRYPTION_STARTTLS);
                $mail->Port = (int) $this->getEnvValue('MAIL_PORT', 587);
                $mail->SMTPDebug = 0;
                $mail->SMTPOptions = [
                    'ssl' => [
                        'verify_peer' => false,
                        'verify_peer_name' => false,
                        'allow_self_signed' => true,
                    ],
                ];
            } else {
                $mail->isMail();
            }

            $mail->setFrom($this->fromAddress, $this->fromName);
            $mail->addAddress($toEmail);
            $mail->isHTML(true);
            $mail->Subject = 'Your BloodConnect Email Verification Code';
            $mail->Body = "
                <div style='font-family:Arial, sans-serif; line-height:1.6;'>
                    <h2>Email Verification</h2>
                    <p>Thank you for registering with BloodConnect.</p>
                    <p>Your verification code is:</p>
                    <h1 style='color:#e63946'>{$otp}</h1>
                    <p>Please enter this code on the verification page to activate your account.</p>
                    <p>This code will expire in 10 minutes.</p>
                </div>
            ";
            $mail->AltBody = "Your BloodConnect verification code is {$otp}. This code will expire in 10 minutes.";

            $sent = $mail->send();

            if (!$sent) {
                error_log('Mail send failed: ' . $mail->ErrorInfo);
            }

            return $sent;
        } catch (Exception $e) {
            error_log('Mail Error: ' . $e->getMessage());
            return false;
        }
    }

    public function sendPasswordResetOtp(string $toEmail, string|int $otp): bool
    {
        $mail = new PHPMailer(true);

        try {
            $host = $this->getEnvValue('MAIL_HOST');
            $username = $this->getEnvValue('MAIL_USERNAME');
            $password = $this->getEnvValue('MAIL_PASSWORD');

            if ($host && $username && $password) {
                $mail->isSMTP();
                $mail->Host = $host;
                $mail->SMTPAuth = true;
                $mail->Username = $username;
                $mail->Password = $password;
                $mail->SMTPSecure = $this->getEnvValue('MAIL_ENCRYPTION', PHPMailer::ENCRYPTION_STARTTLS);
                $mail->Port = (int) $this->getEnvValue('MAIL_PORT', 587);
                $mail->SMTPDebug = 0;
                $mail->SMTPOptions = [
                    'ssl' => [
                        'verify_peer' => false,
                        'verify_peer_name' => false,
                        'allow_self_signed' => true,
                    ],
                ];
            } else {
                $mail->isMail();
            }

            $mail->setFrom($this->fromAddress, $this->fromName);
            $mail->addAddress($toEmail);
            $mail->isHTML(true);
            $mail->Subject = 'BloodConnect Password Reset Code';
            $mail->Body = "
                <div style='font-family:Arial, sans-serif; line-height:1.6;'>
                    <h2>Password Reset</h2>
                    <p>You requested a password reset for your BloodConnect account.</p>
                    <p>Your reset code is:</p>
                    <h1 style='color:#e63946'>{$otp}</h1>
                    <p>Please enter this code to continue resetting your password.</p>
                    <p>This code will expire in 10 minutes.</p>
                </div>
            ";
            $mail->AltBody = "Your BloodConnect password reset code is {$otp}. This code will expire in 10 minutes.";

            $sent = $mail->send();

            if (!$sent) {
                error_log('Password reset mail send failed: ' . $mail->ErrorInfo);
            }

            return $sent;
        } catch (Exception $e) {
            error_log('Password reset mail error: ' . $e->getMessage());
            return false;
        }
    }

    public function sendBloodRequestAlert(string $toEmail, array $request): bool
    {
        $mail = new PHPMailer(true);

        $patientName = htmlspecialchars((string)($request['patient_name'] ?? 'A patient'));
        $bloodGroup = htmlspecialchars((string)($request['blood_group_needed'] ?? ''));
        $hospital = htmlspecialchars((string)($request['hospital_name'] ?? 'the hospital'));
        $urgency = htmlspecialchars(strtoupper((string)($request['urgency'] ?? 'ROUTINE')));
        $requestCode = htmlspecialchars((string)($request['request_code'] ?? ''));

        try {
            $host = $this->getEnvValue('MAIL_HOST');
            $username = $this->getEnvValue('MAIL_USERNAME');
            $password = $this->getEnvValue('MAIL_PASSWORD');

            if ($host && $username && $password) {
                $mail->isSMTP();
                $mail->Host = $host;
                $mail->SMTPAuth = true;
                $mail->Username = $username;
                $mail->Password = $password;
                $mail->SMTPSecure = $this->getEnvValue('MAIL_ENCRYPTION', PHPMailer::ENCRYPTION_STARTTLS);
                $mail->Port = (int) $this->getEnvValue('MAIL_PORT', 587);
                $mail->SMTPDebug = 0;
                $mail->SMTPOptions = [
                    'ssl' => [
                        'verify_peer' => false,
                        'verify_peer_name' => false,
                        'allow_self_signed' => true,
                    ],
                ];
            } else {
                $mail->isMail();
            }

            $mail->setFrom($this->fromAddress, $this->fromName);
            $mail->addAddress($toEmail);
            $mail->isHTML(true);
            $mail->Subject = "BloodConnect: Urgent {$bloodGroup} Blood Request ({$requestCode})";
            $mail->Body = "
                <div style='font-family:Arial, sans-serif; line-height:1.6;'>
                    <h2>New Blood Request Alert</h2>
                    <p>Hello,</p>
                    <p>A blood request has been registered that matches your blood group.</p>
                    <p><strong>Request Code:</strong> {$requestCode}</p>
                    <p><strong>Patient:</strong> {$patientName}</p>
                    <p><strong>Blood Group Needed:</strong> {$bloodGroup}</p>
                    <p><strong>Urgency:</strong> {$urgency}</p>
                    <p><strong>Hospital:</strong> {$hospital}</p>
                    <p>Please log in to your BloodConnect donor account to review and respond to the request.</p>
                    <p>Thank you for being a lifesaver.</p>
                </div>
            ";
            $mail->AltBody = "A {$bloodGroup} blood request ({$requestCode}) from {$patientName} at {$hospital} needs your help. Log in to BloodConnect to respond.";

            $sent = $mail->send();

            if (!$sent) {
                error_log('Blood request alert mail failed: ' . $mail->ErrorInfo);
            }

            return $sent;
        } catch (Exception $e) {
            error_log('Blood request alert mail error: ' . $e->getMessage());
            return false;
        }
    }

    private function getEnvValue(string $key, mixed $default = null): mixed
    {
        $value = getenv($key);

        if ($value !== false && $value !== '') {
            return $value;
        }

        $envFile = __DIR__ . '/../../../../.env';
        if (!file_exists($envFile)) {
            return $default;
        }

        $lines = file($envFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        foreach ($lines as $line) {
            if (str_starts_with(trim($line), '#')) {
                continue;
            }

            [$name, $val] = array_pad(explode('=', $line, 2), 2, '');
            if (trim($name) === $key) {
                return trim($val);
            }
        }

        return $default;
    }
}
