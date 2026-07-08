<?php

namespace App\Donor\Infrastructure\Persistence;

use App\Donor\Domain\Repository\DonorRepositoryInterface;
use App\Shared\Infrastructure\Database\Database;
use PDO;

class DonorRepository implements DonorRepositoryInterface
{
    private PDO $db;

    public function __construct()
    {
        $this->db = Database::getConnection();
    }

    public function findById(int $id)
    {
        $stmt = $this->db->prepare("SELECT * FROM users WHERE user_id = ?");
        $stmt->execute([$id]);

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function search(array $criteria)
    {
        $sql = "SELECT * FROM users WHERE 1=1";
        $params = [];

        if (!empty($criteria['username'])) {
            $sql .= " AND username LIKE ?";
            $params[] = '%' . $criteria['username'] . '%';
        }

        if (!empty($criteria['blood_group'])) {
            $sql .= " AND blood_group = ?";
            $params[] = $criteria['blood_group'];
        }

        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function updateProfile(int $id, array $data): bool
    {
        $setClauses = [
            'username = ?',
            'email = ?',
            'phone = ?',
            'blood_group = ?',
            'address = ?',
            'updated_at = NOW()'
        ];

        $params = [
            trim((string)($data['username'] ?? '')),
            trim((string)($data['email'] ?? '')),
            trim((string)($data['phone'] ?? '')),
            trim((string)($data['blood_group'] ?? '')),
            trim((string)($data['address'] ?? '')),
        ];

        if (!empty($data['password'])) {
            $setClauses[] = 'password = ?';
            $params[] = password_hash($data['password'], PASSWORD_BCRYPT);
        }

        $params[] = $id;

        $sql = 'UPDATE users SET ' . implode(', ', $setClauses) . ' WHERE user_id = ?';
        $stmt = $this->db->prepare($sql);

        return $stmt->execute($params);
    }
}
