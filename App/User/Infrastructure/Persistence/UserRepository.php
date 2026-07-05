<?php

namespace App\User\Infrastructure\Persistence;

use App\User\Domain\Repository\UserRepositoryInterface;
use App\Shared\Infrastructure\Database\Database;
use PDO;

class UserRepository implements UserRepositoryInterface
{
    private PDO $db;

    public function __construct()
    {
        $this->db = Database::getConnection();
    }

    public function findById(int $id)
    {
        $stmt = $this->db->prepare("
            SELECT *
            FROM users
            WHERE user_id = ?
        ");

        $stmt->execute([$id]);

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function update(int $id, array $data)
    {
        $stmt = $this->db->prepare("
            UPDATE users
            SET
                username = ?,
                email = ?,
                phone = ?,
                blood_group = ?,
                address = ?
            WHERE user_id = ?
        ");

        return $stmt->execute([
            $data['username'],
            $data['email'],
            $data['phone'],
            $data['blood_group'],
            $data['address'],
            $id
        ]);
    }

    public function findAll(): array
    {
        $stmt = $this->db->query("
        SELECT *
        FROM users
    ");

        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }
}
