<?php

namespace App\Shared\Helpers;

use App\Authentication\Infrastructure\Persistence\AuthRepository;

class Permission
{
    public static function can(string $permission): bool
    {
        Session::start();

        $permissions = self::loadPermissions();

        if ($permissions === '*') {
            return true;
        }

        if (!is_array($permissions)) {
            return false;
        }

        $requestedPermission = self::normalizeToken($permission);

        foreach ($permissions as $storedPermission) {
            if (!is_string($storedPermission)) {
                continue;
            }

            if (self::matchesPermission($requestedPermission, $storedPermission)) {
                return true;
            }
        }

        return false;
    }

    private static function loadPermissions(): array|string
    {
        $sessionPermissions = Session::get('permissions', []);
        $userTypeId = Session::get('user_type_id');

        if ($userTypeId === null) {
            return $sessionPermissions;
        }

        $repo = new AuthRepository();
        $freshPermissions = $repo->getPermissionsByUserType((int) $userTypeId);

        if ($freshPermissions === '*') {
            Session::set('permissions', '*');
            return '*';
        }

        $freshPermissions = is_array($freshPermissions) ? array_values(array_unique($freshPermissions)) : [];

        if ($sessionPermissions !== $freshPermissions) {
            Session::set('permissions', $freshPermissions);
        }

        return $freshPermissions;
    }

    private static function matchesPermission(
        string $requestedPermission,
        string $storedPermission
    ): bool {
        return $requestedPermission === self::normalizeToken($storedPermission);
    }

    
    private static function normalizeToken(string $value): string
    {
        $value = strtolower(trim($value));
        $value = preg_replace('/[^a-z0-9]+/', '', $value) ?? '';

        return rtrim($value, 's');
    }
}
