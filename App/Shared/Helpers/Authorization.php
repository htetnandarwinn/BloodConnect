<?php

namespace App\Shared\Helpers;

use App\Shared\Infrastructure\Database\Database;

class Authorization
{
    public static function can(string $permission): bool
    {
        Session::start();

        $userTypeId = $_SESSION['user']['user_type_id'] ?? null;

        if (!$userTypeId) {
            return false;
        }

        $db = Database::getConnection();

        $stmt = $db->prepare("
            SELECT permissions
            FROM user_types
            WHERE id = ?
            LIMIT 1
        ");

        $stmt->execute([$userTypeId]);

        $row = $stmt->fetch();

        if (!$row) {
            return false;
        }

        $permissions = trim($row['permissions']);

        // Admin has all permissions
        if ($permissions === '*') {
            return true;
        }

        $permissionList = array_map('trim', explode(',', $permissions));

        return in_array($permission, $permissionList);
    }

    public static function require(string $permission): void
    {
        if (!self::can($permission)) {

            http_response_code(403);

            die("<h2>403 Forbidden</h2><p>You don't have permission to access this page.</p>");
        }
    }
}
