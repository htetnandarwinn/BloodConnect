<?php

namespace App\Shared\Infrastructure\OAuth;

class GoogleOAuth
{
    private string $clientId;
    private string $clientSecret;
    private string $redirectUri;

    public function __construct()
    {
        $this->clientId = (string)$this->getEnvValue('GOOGLE_CLIENT_ID', '');
        $this->clientSecret = (string)$this->getEnvValue('GOOGLE_CLIENT_SECRET', '');
        $this->redirectUri = (string)$this->getEnvValue(
            'GOOGLE_REDIRECT_URI',
            $this->buildDefaultRedirectUri()
        );
    }

    public function isConfigured(): bool
    {
        $placeholders = [
            '',
            'your_google_client_id',
            'your_client_id_here',
            'your_google_client_secret',
            'your_client_secret_here',
            'your-client-id.apps.googleusercontent.com',
            'your-client-secret',
        ];

        return !in_array(strtolower(trim($this->clientId)), array_map('strtolower', $placeholders), true)
            && !in_array(strtolower(trim($this->clientSecret)), array_map('strtolower', $placeholders), true);
    }

    public function getAuthorizationUrl(): string
    {
        if (!$this->isConfigured()) {
            return '';
        }

        return 'https://accounts.google.com/o/oauth2/v2/auth?' . http_build_query([
            'client_id'     => $this->clientId,
            'redirect_uri'  => $this->redirectUri,
            'response_type' => 'code',
            'scope'         => 'openid email profile',
            'access_type'   => 'online',
            'prompt'        => 'select_account',
        ]);
    }

    private function getEnvValue(string $key, mixed $default = null): mixed
    {
        // Read .env first
        $envPath = dirname(__DIR__, 4) . '/.env';

        if (file_exists($envPath)) {

            $lines = file($envPath, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

            foreach ($lines as $line) {

                $line = trim($line);

                if ($line === '' || str_starts_with($line, '#')) {
                    continue;
                }

                if (!str_contains($line, '=')) {
                    continue;
                }

                [$name, $value] = explode('=', $line, 2);

                if (trim($name) === $key) {
                    return trim($value, "\"' ");
                }
            }
        }

        // Fallback to getenv()
        $value = getenv($key);

        if ($value !== false && $value !== '') {
            return $value;
        }

        return $default;
    }

    private function buildDefaultRedirectUri(): string
    {
        $scheme = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off')
            ? 'https'
            : 'http';

        $host = $_SERVER['HTTP_HOST'] ?? 'localhost';

        $scriptName = $_SERVER['SCRIPT_NAME'] ?? '';

        $basePath = rtrim(dirname($scriptName), '/');

        return $scheme . '://' . $host . $basePath . '/auth/google/callback';
    }

    public function fetchAccessToken(string $code): ?array
    {
        $ch = curl_init('https://oauth2.googleapis.com/token');

        curl_setopt_array($ch, [
            CURLOPT_POST => true,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POSTFIELDS => http_build_query([
                'code' => $code,
                'client_id' => $this->clientId,
                'client_secret' => $this->clientSecret,
                'redirect_uri' => $this->redirectUri,
                'grant_type' => 'authorization_code',
            ]),
        ]);

        $response = curl_exec($ch);

        if ($response === false) {
            curl_close($ch);
            return null;
        }

        $status = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        curl_close($ch);

        if ($status !== 200) {
            return null;
        }

        return json_decode($response, true);
    }

    public function fetchUserInfo(string $accessToken): ?array
    {
        $ch = curl_init('https://www.googleapis.com/oauth2/v2/userinfo');

        curl_setopt_array($ch, [
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HTTPHEADER => [
                'Authorization: Bearer ' . $accessToken,
            ],
        ]);

        $response = curl_exec($ch);

        if ($response === false) {
            curl_close($ch);
            return null;
        }

        $status = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        curl_close($ch);

        if ($status !== 200) {
            return null;
        }

        return json_decode($response, true);
    }
}
