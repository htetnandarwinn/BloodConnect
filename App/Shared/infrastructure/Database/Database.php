<?php

namespace App\Shared\Infrastructure\Database;

use PDO;
use PDOException;

class Database
{
    private static ?PDO $connection = null;

    /**
     * Loads environment variables from App/.env (if present) so database
     * credentials are no longer hardcoded in source. Existing process env
     * values take precedence. Safe to call multiple times.
     */
    private static function loadEnv(): void
    {
        static $loaded = false;

        if ($loaded) {
            return;
        }

        $loaded = true;

        $file = dirname(__DIR__, 3) . '/.env';

        if (!is_file($file)) {
            return;
        }

        foreach (file($file, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES) as $line) {
            $line = trim($line);

            if ($line === '' || str_starts_with($line, '#')) {
                continue;
            }

            if (!str_contains($line, '=')) {
                continue;
            }

            [$key, $value] = explode('=', $line, 2);
            $key = trim($key);
            $value = trim($value);

            if ($key === '' || getenv($key) !== false) {
                continue;
            }

            putenv("{$key}={$value}");
            $_ENV[$key] = $value;
        }
    }

    public static function getConnection(): PDO
    {
        if (self::$connection !== null) {
            return self::$connection;
        }

        self::loadEnv();

        $host = getenv('DB_HOST') ?: 'localhost';
        $dbname = getenv('DB_NAME') ?: 'bloodconnect01';
        $username = getenv('DB_USER') ?: 'root';
        $password = getenv('DB_PASS') ?: '';

        try {
            self::$connection = new PDO(
                "mysql:host={$host};dbname={$dbname};charset=utf8mb4",
                $username,
                $password,
                [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                    PDO::ATTR_EMULATE_PREPARES => false,
                ]
            );

            return self::$connection;

        } catch (PDOException $e) {
            throw new \Exception("DB Connection failed: " . $e->getMessage());
        }
    }
}