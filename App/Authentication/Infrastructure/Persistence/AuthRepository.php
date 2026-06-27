<?php

namespace App\Authentication\Infrastructure\Persistence;

use App\Authentication\Domain\Repository\AuthRepositoryInterface;

require_once __DIR__ . '/../../Domain/Repository/AuthRepositoryInterface.php';

class AuthRepository implements AuthRepositoryInterface
{
    public function findByEmail(string $email)
    {
        require_once __DIR__ . '/../../../Shared/infrastructure/Database/Database.php';
        $db = new \Database();
        $pdo = $db->connect();

        $sql = "SELECT * FROM users WHERE email = :login OR username = :login LIMIT 1";
        $stmt = $pdo->prepare($sql);
        $stmt->execute(['login' => $email]);
        $user = $stmt->fetch(\PDO::FETCH_ASSOC);

        return $user ?: null;
    }

    public function create(array $data)
    {
        require_once __DIR__ . '/../../../Shared/infrastructure/Database/Database.php';
        $db = new \Database();
        $pdo = $db->connect();

        $sql = "INSERT INTO users (name, username, email, phone, password, role, created_at) VALUES (:name, :username, :email, :phone, :password, :role, :created_at)";
        $stmt = $pdo->prepare($sql);

        try {
            $stmt->execute([
                'name' => $data['name'] ?? null,
                'username' => $data['username'] ?? null,
                'email' => $data['email'] ?? null,
                'phone' => $data['phone'] ?? null,
                'password' => $data['password'] ?? null,
                'role' => $data['role'] ?? 'user',
                'created_at' => date('Y-m-d H:i:s'),
            ]);

            return (int)$pdo->lastInsertId();
        } catch (\PDOException $e) {
            if (isset($e->errorInfo[1]) && $e->errorInfo[1] === 1062) {
                return false;
            }

            throw $e;
        }
    }

    public function registerDonor($data)
    {
        // create user first
        $passwordHash = password_hash($data['password'] ?? bin2hex(random_bytes(4)), PASSWORD_DEFAULT);
        $userId = $this->create([
            'name' => $data['name'] ?? null,
            'email' => $data['email'] ?? null,
            'password' => $passwordHash,
            'role' => 'donor',
        ]);

        if ($userId === false) {
            return false;
        }

        require_once __DIR__ . '/../../../Shared/infrastructure/Database/Database.php';
        $db = new \Database();
        $pdo = $db->connect();

        $sql = "INSERT INTO donors (user_id, name, dob, email, phone, blood_group, gender, address, weight, last_donation_date, availability, created_at) VALUES (:user_id, :name, :dob, :email, :phone, :blood_group, :gender, :address, :weight, :last_donation_date, :availability, :created_at)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            'user_id' => $userId,
            'name' => $data['name'] ?? null,
            'dob' => $data['dob'] ?? null,
            'email' => $data['email'] ?? null,
            'phone' => $data['phone'] ?? null,
            'blood_group' => $data['blood_group'] ?? null,
            'gender' => $data['gender'] ?? null,
            'address' => $data['address'] ?? null,
            'weight' => $data['weight'] ?? null,
            'last_donation_date' => $data['last_donation_date'] ?? null,
            'availability' => $data['availability'] ?? 1,
            'created_at' => date('Y-m-d H:i:s'),
        ]);

        return $userId;
    }

    public function registerPatient($data)
    {
        $passwordHash = password_hash($data['password'] ?? bin2hex(random_bytes(4)), PASSWORD_DEFAULT);
        $userId = $this->create([
            'name' => $data['name'] ?? $data['username'] ?? null,
            'username' => $data['username'] ?? null,
            'email' => $data['email'] ?? null,
            'password' => $passwordHash,
            'role' => $data['role'] ?? 'patient',
        ]);

        if ($userId === false) {
            return false;
        }

        return $userId;
    }
}
