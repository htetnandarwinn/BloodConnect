<?php

namespace App\Shared\Infrastructure\Database;

use PDO;
use PDOException;

class Database
{
    private static ?PDO $connection = null;

    private string $host = "localhost";
    private string $dbname = "bloodconnect01";
    private string $username = "root";
    private string $password = "";

    public static function getConnection(): PDO
    {
        if (self::$connection !== null) {
            return self::$connection;
        }

        try {
            $instance = new self();

            self::$connection = new PDO(
                "mysql:host={$instance->host};dbname={$instance->dbname};charset=utf8mb4",
                $instance->username,
                $instance->password,
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