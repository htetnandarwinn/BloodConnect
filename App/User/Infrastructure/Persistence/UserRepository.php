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
        $db = Database::getConnection();

        if (!empty($data['password'])) {

            $password = password_hash($data['password'], PASSWORD_DEFAULT);

            $stmt = $db->prepare("
            UPDATE users
            SET username=?,
                email=?,
                phone=?,
                blood_group=?,
                address=?,
                password=?
            WHERE user_id=?
        ");

            return $stmt->execute([
                $data['username'],
                $data['email'],
                $data['phone'],
                $data['blood_group'],
                $data['address'],
                $password,
                $id
            ]);
        } else {

            $stmt = $db->prepare("
            UPDATE users
            SET username=?,
                email=?,
                phone=?,
                blood_group=?,
                address=?
            WHERE user_id=?
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
    }

    public function findAll(): array
    {
        $stmt = $this->db->query("
        SELECT *
        FROM users
    ");

        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function getAdmins(): array
    {
        $stmt = $this->db->prepare("
        SELECT user_id, username
        FROM users
        WHERE user_type_id = 1
    ");

        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
