<?php

namespace App\Shared\Infrastructure\Persistence;

use App\Shared\Infrastructure\Database\Database;
use PDO;

class PermissionRepository
{
    private PDO $db;

    public function __construct()
    {
        $this->db = Database::getConnection();
    }

    public function getPermissionsByUserType(int $userTypeId): array
    {
        $stmt = $this->db->prepare("
            SELECT p.permission_key
            FROM permissions p
            INNER JOIN user_type_permissions utp
                ON utp.permission_id = p.permission_id
            WHERE utp.user_type_id = ?
        ");

        $stmt->execute([$userTypeId]);

        return $stmt->fetchAll(PDO::FETCH_COLUMN);
    }
}
