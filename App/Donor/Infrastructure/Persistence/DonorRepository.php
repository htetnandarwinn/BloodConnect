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

    private function ensureNextAvailableDateColumn(): void
    {
        try {
            $stmt = $this->db->query("SHOW COLUMNS FROM users LIKE 'next_available_date'");
            if ($stmt->rowCount() === 0) {
                $this->db->exec("ALTER TABLE users ADD COLUMN next_available_date DATETIME DEFAULT NULL");
            }
        } catch (\PDOException $e) {
            if (strpos($e->getMessage(), 'next_available_date') !== false) {
                $this->db->exec("ALTER TABLE users ADD COLUMN next_available_date DATETIME DEFAULT NULL");
            } else {
                throw $e;
            }
        }
    }

    public function syncAvailabilityStatus(int $userId): array
    {
        $this->ensureNextAvailableDateColumn();

        $stmt = $this->db->prepare("SELECT available, next_available_date FROM users WHERE user_id = ?");
        $stmt->execute([$userId]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$row) {
            return [
                'available' => true,
                'next_available_date' => null
            ];
        }

        $available = (int)($row['available'] ?? 1) === 1;
        $nextAvailableDate = trim((string)($row['next_available_date'] ?? ''));

        if (!$available && $nextAvailableDate !== '') {
            $timezone = new \DateTimeZone('Asia/Yangon');
            $now = new \DateTime('now', $timezone);
            $nextDate = \DateTime::createFromFormat('Y-m-d H:i:s', $nextAvailableDate, $timezone);

            if ($nextDate === false) {
                $nextDate = new \DateTime($nextAvailableDate, $timezone);
            }

            if ($nextDate !== false && $now >= $nextDate) {
                $update = $this->db->prepare("UPDATE users SET available = 1, next_available_date = NULL WHERE user_id = ?");
                $update->execute([$userId]);

                return [
                    'available' => true,
                    'next_available_date' => null
                ];
            }
        }

        return [
            'available' => $available,
            'next_available_date' => $nextAvailableDate !== '' ? $nextAvailableDate : null
        ];
    }

    public function saveNextAvailableDate(int $userId, string $nextAvailableDate): bool
    {
        $this->ensureNextAvailableDateColumn();

        $stmt = $this->db->prepare("UPDATE users SET available = 0, next_available_date = ? WHERE user_id = ?");
        return $stmt->execute([$nextAvailableDate, $userId]);
    }

    public function updateProfile(int $id, array $data): bool
    {
        $setClauses = [
            'username = ?',
            'email = ?',
            'phone = ?',
            'address = ?',
            'updated_at = NOW()'
        ];

        $params = [
            trim((string)($data['username'] ?? '')),
            trim((string)($data['email'] ?? '')),
            trim((string)($data['phone'] ?? '')),
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

    public function createDonorProfile(int $userId): bool
    {
        $stmt = $this->db->prepare("INSERT INTO donors (user_id) VALUES (?)");
        return $stmt->execute([$userId]);
    }
}
