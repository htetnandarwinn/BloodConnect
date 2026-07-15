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
        $this->ensureLocationColumns();

        $stmt = $this->db->prepare("
            SELECT u.available, u.next_available_date, d.date_of_birth, d.weight
            FROM users u
            LEFT JOIN donors d ON d.user_id = u.user_id
            WHERE u.user_id = ?
        ");
        $stmt->execute([$userId]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$row) {
            return [
                'available' => true,
                'next_available_date' => null
            ];
        }

        // Check age/weight eligibility
        $profileEligible = true;
        if (!empty($row['date_of_birth']) && !empty($row['weight'])) {
            $eligibility = (new \App\Donor\Domain\Service\DonorEligibilityService())->evaluate(
                (string)($row['date_of_birth'] ?? ''),
                (string)($row['weight'] ?? '')
            );
            $profileEligible = $eligibility['eligible'];
        }

        if (!$profileEligible) {
            $update = $this->db->prepare("UPDATE users SET available = 0 WHERE user_id = ?");
            $update->execute([$userId]);
            return [
                'available' => false,
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

    public function ensureDonorColumns(): void
    {
        try {
            $stmt = $this->db->query("SHOW COLUMNS FROM donors LIKE 'date_of_birth'");
            if ($stmt->rowCount() === 0) {
                $this->db->exec("ALTER TABLE donors ADD COLUMN date_of_birth DATE DEFAULT NULL AFTER weight");
            }
        } catch (\PDOException $e) {
            if (strpos($e->getMessage(), 'date_of_birth') !== false) {
                $this->db->exec("ALTER TABLE donors ADD COLUMN date_of_birth DATE DEFAULT NULL AFTER weight");
            } else {
                throw $e;
            }
        }
    }

    public function ensureLocationColumns(): void
    {
        try {
            $stmt = $this->db->query("SHOW COLUMNS FROM donors LIKE 'state_region'");
            if ($stmt->rowCount() === 0) {
                $this->db->exec("ALTER TABLE donors ADD COLUMN state_region VARCHAR(100) DEFAULT NULL AFTER date_of_birth");
            }
        } catch (\PDOException $e) {
            if (strpos($e->getMessage(), 'state_region') !== false) {
                $this->db->exec("ALTER TABLE donors ADD COLUMN state_region VARCHAR(100) DEFAULT NULL AFTER date_of_birth");
            } else {
                throw $e;
            }
        }

        try {
            $stmt = $this->db->query("SHOW COLUMNS FROM donors LIKE 'township'");
            if ($stmt->rowCount() === 0) {
                $this->db->exec("ALTER TABLE donors ADD COLUMN township VARCHAR(100) DEFAULT NULL AFTER state_region");
            }
        } catch (\PDOException $e) {
            if (strpos($e->getMessage(), 'township') !== false) {
                $this->db->exec("ALTER TABLE donors ADD COLUMN township VARCHAR(100) DEFAULT NULL AFTER state_region");
            } else {
                throw $e;
            }
        }
    }

    public function saveLocation(int $userId, string $stateRegion, string $township): bool
    {
        $this->ensureLocationColumns();

        $stmt = $this->db->prepare("UPDATE donors SET state_region = ?, township = ? WHERE user_id = ?");
        return $stmt->execute([$stateRegion, $township, $userId]);
    }

    public function getDonorDetails(int $userId): ?array
    {
        $this->ensureDonorColumns();
        $this->ensureLocationColumns();

        $stmt = $this->db->prepare("
            SELECT d.*, u.username, u.email, u.phone, u.blood_group, u.address
            FROM donors d
            JOIN users u ON u.user_id = d.user_id
            WHERE d.user_id = ?
        ");
        $stmt->execute([$userId]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result ?: null;
    }

    public function saveDonorDetails(int $userId, array $data): bool
    {
        $this->ensureDonorColumns();
        $this->ensureLocationColumns();

        $fields = [];
        $params = [];

        if (isset($data['date_of_birth'])) {
            $fields[] = 'date_of_birth = ?';
            $params[] = $data['date_of_birth'];
        }
        if (isset($data['weight'])) {
            $fields[] = 'weight = ?';
            $params[] = $data['weight'];
        }
        if (isset($data['state_region'])) {
            $fields[] = 'state_region = ?';
            $params[] = $data['state_region'];
        }
        if (isset($data['township'])) {
            $fields[] = 'township = ?';
            $params[] = $data['township'];
        }

        if (empty($fields)) {
            return true;
        }

        $params[] = $userId;
        $sql = 'UPDATE donors SET ' . implode(', ', $fields) . ' WHERE user_id = ?';
        $stmt = $this->db->prepare($sql);
        return $stmt->execute($params);
    }

    public function isProfileComplete(int $userId): bool
    {
        $this->ensureDonorColumns();

        $stmt = $this->db->prepare("SELECT date_of_birth, weight FROM donors WHERE user_id = ?");
        $stmt->execute([$userId]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$row) {
            return false;
        }

        return !empty($row['date_of_birth']) && !empty($row['weight']);
    }

    public function updateWeight(int $userId, string $weight): bool
    {
        $stmt = $this->db->prepare("UPDATE donors SET weight = ? WHERE user_id = ?");
        return $stmt->execute([$weight, $userId]);
    }
}
