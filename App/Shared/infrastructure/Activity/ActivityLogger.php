<?php

namespace App\Shared\Infrastructure\Activity;

use App\Shared\Infrastructure\Database\Database;
use PDO;

class ActivityLogger
{
    private PDO $db;

    public function __construct()
    {
        $this->db = Database::getConnection();
    }

    public function log(?int $userId, ?string $userName, string $action, string $message, string $type = 'INFO'): void
    {
        $stmt = $this->db->prepare("
            INSERT INTO activity_logs (user_id, user_name, action, message, type)
            VALUES (?, ?, ?, ?, ?)
        ");

        $stmt->execute([
            $userId,
            $userName,
            $action,
            $message,
            $type
        ]);
    }

    public function getLatest(int $limit = 10): array
    {
        $stmt = $this->db->prepare("
            SELECT * FROM activity_logs
            ORDER BY created_at DESC
            LIMIT ?
        ");

        $stmt->bindValue(1, $limit, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll();
    }
}
