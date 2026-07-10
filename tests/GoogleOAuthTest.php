<?php

require __DIR__ . '/../vendor/autoload.php';

use App\Shared\Infrastructure\OAuth\GoogleOAuth;

function assertGoogleOAuthTest(bool $condition, string $message): void
{
    if (!$condition) {
        fwrite(STDERR, "FAILED: $message\n");
        exit(1);
    }
}

putenv('GOOGLE_CLIENT_ID=test-client-id');
putenv('GOOGLE_CLIENT_SECRET=test-client-secret');
putenv('GOOGLE_REDIRECT_URI=http://localhost/BloodConnect/public/auth/google/callback');

$oauth = new GoogleOAuth();
$url = $oauth->getAuthorizationUrl();

assertGoogleOAuthTest(str_contains($url, 'client_id=test-client-id'), 'OAuth should read client ID from environment variables');
assertGoogleOAuthTest(str_contains($url, 'redirect_uri=http%3A%2F%2Flocalhost%2FBloodConnect%2Fpublic%2Fauth%2Fgoogle%2Fcallback'), 'OAuth should read redirect URI from environment variables');

putenv('GOOGLE_CLIENT_ID=your_google_client_id');
putenv('GOOGLE_CLIENT_SECRET=your_google_client_secret');
$placeholderOAuth = new GoogleOAuth();
assertGoogleOAuthTest(!$placeholderOAuth->isConfigured(), 'placeholder credentials should be treated as unconfigured');

echo "Google OAuth tests passed\n";
