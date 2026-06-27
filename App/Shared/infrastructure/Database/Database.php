<?php

class Database
{
    private $host = "localhost";
    private $dbname = "bloodconnect01";
    private $username = "root";
    private $password = "";

    public function connect()
    {
        try {
            $pdo = new PDO(
                "mysql:host={$this->host};dbname={$this->dbname}",
                $this->username,
                $this->password
            );

            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $this->initializeSchema($pdo);

            return $pdo;
        } catch (PDOException $e) {
            die("Database Connection Failed: " . $e->getMessage());
        }
    }

    private function initializeSchema(PDO $pdo)
    {
        $pdo->exec(
            'CREATE TABLE IF NOT EXISTS users (
                id INT AUTO_INCREMENT PRIMARY KEY,
                name VARCHAR(255) NULL,
                email VARCHAR(255) NOT NULL UNIQUE,
                username VARCHAR(100) NULL,
                phone VARCHAR(100) NULL,
                user_type_id INT NULL,
                status_id INT NULL,
                password VARCHAR(255) NOT NULL,
                role VARCHAR(50) NOT NULL DEFAULT "user",
                created_at DATETIME NULL
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4'
        );

        $this->dropAllForeignKeys($pdo, 'users');
        $this->ensureNullableColumn(
            $pdo,
            'users',
            'user_type_id',
            'user_type_id INT NULL'
        );
        $this->ensureNullableColumn(
            $pdo,
            'users',
            'status_id',
            'status_id INT NULL'
        );
        $this->ensureColumnExists(
            $pdo,
            'users',
            'name',
            'name VARCHAR(255) NULL'
        );
        $this->ensureColumnExists(
            $pdo,
            'users',
            'username',
            'username VARCHAR(100) NULL'
        );
        $this->ensureColumnExists(
            $pdo,
            'users',
            'phone',
            'phone VARCHAR(100) NULL'
        );
        $this->ensureColumnExists(
            $pdo,
            'users',
            'role',
            'role VARCHAR(50) NOT NULL DEFAULT "user"'
        );
        $this->ensureColumnExists(
            $pdo,
            'users',
            'created_at',
            'created_at DATETIME NULL'
        );

        $pdo->exec(
            'CREATE TABLE IF NOT EXISTS donors (
                id INT AUTO_INCREMENT PRIMARY KEY,
                user_id INT NOT NULL,
                name VARCHAR(255) NULL,
                dob DATE NULL,
                email VARCHAR(255) NULL,
                phone VARCHAR(100) NULL,
                blood_group VARCHAR(10) NULL,
                gender VARCHAR(50) NULL,
                address TEXT NULL,
                weight VARCHAR(50) NULL,
                last_donation_date DATE NULL,
                availability TINYINT(1) NOT NULL DEFAULT 1,
                created_at DATETIME NULL,
                INDEX (user_id)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4'
        );

        $this->ensureColumnExists(
            $pdo,
            'donors',
            'user_id',
            'user_id INT NOT NULL'
        );
        $this->ensureColumnExists(
            $pdo,
            'donors',
            'name',
            'name VARCHAR(255) NULL'
        );
        $this->ensureColumnExists(
            $pdo,
            'donors',
            'dob',
            'dob DATE NULL'
        );
        $this->ensureColumnExists(
            $pdo,
            'donors',
            'blood_group',
            'blood_group VARCHAR(10) NULL'
        );
        $this->ensureColumnExists(
            $pdo,
            'donors',
            'gender',
            'gender VARCHAR(50) NULL'
        );
        $this->ensureColumnExists(
            $pdo,
            'donors',
            'address',
            'address TEXT NULL'
        );
        $this->ensureColumnExists(
            $pdo,
            'donors',
            'weight',
            'weight VARCHAR(50) NULL'
        );
        $this->ensureColumnExists(
            $pdo,
            'donors',
            'last_donation_date',
            'last_donation_date DATE NULL'
        );
        $this->ensureColumnExists(
            $pdo,
            'donors',
            'profile_photo',
            'profile_photo VARCHAR(255) NULL'
        );
        $this->ensureColumnExists(
            $pdo,
            'donors',
            'availability',
            'availability TINYINT(1) NOT NULL DEFAULT 1'
        );
        $this->ensureColumnExists(
            $pdo,
            'donors',
            'created_at',
            'created_at DATETIME NULL'
        );
    }

    private function dropAllForeignKeys(PDO $pdo, string $table)
    {
        $stmt = $pdo->prepare(
            'SELECT CONSTRAINT_NAME
            FROM INFORMATION_SCHEMA.TABLE_CONSTRAINTS
            WHERE TABLE_SCHEMA = DATABASE()
                AND TABLE_NAME = :table
                AND CONSTRAINT_TYPE = "FOREIGN KEY"'
        );
        $stmt->execute([
            'table' => $table,
        ]);

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $pdo->exec("ALTER TABLE `{$table}` DROP FOREIGN KEY `{$row['CONSTRAINT_NAME']}`");
        }
    }

    private function ensureColumnExists(PDO $pdo, string $table, string $column, string $definition)
    {
        $stmt = $pdo->prepare("SHOW COLUMNS FROM `{$table}` LIKE :column");
        $stmt->execute(['column' => $column]);

        if ($stmt->rowCount() === 0) {
            $pdo->exec("ALTER TABLE `{$table}` ADD COLUMN {$definition}");
        }
    }

    private function ensureNullableColumn(PDO $pdo, string $table, string $column, string $definition)
    {
        $this->ensureColumnExists($pdo, $table, $column, $definition);
    }
}
