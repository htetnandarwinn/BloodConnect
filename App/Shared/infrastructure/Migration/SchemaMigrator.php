<?php

namespace App\Shared\Infrastructure\Migration;

use App\Shared\Infrastructure\Database\Database;
use PDO;

/**
 * Idempotent schema migration that ensures the application's required columns
 * exist. Previously this DDL was executed ad-hoc inside repository methods on
 * the request hot path (a Single-Responsibility violation). It now runs once
 * per process at bootstrap via index.php.
 *
 * Safe to call repeatedly: every change is guarded by a SHOW COLUMNS check.
 */
class SchemaMigrator
{
    private bool $migrated = false;

    public function migrate(): void
    {
        if ($this->migrated) {
            return;
        }

        $db = Database::getConnection();

        $this->ensureColumn($db, 'blood_requests', 'state_region', 'VARCHAR(100) DEFAULT NULL AFTER hospital_name');
        $this->ensureColumn($db, 'blood_requests', 'township', 'VARCHAR(100) DEFAULT NULL AFTER state_region');
        $this->ensureColumn($db, 'blood_requests', 'hospital_address', 'TEXT DEFAULT NULL AFTER township');
        $this->ensureColumn($db, 'donors', 'date_of_birth', 'DATE DEFAULT NULL AFTER weight');
        $this->ensureColumn($db, 'donors', 'state_region', 'VARCHAR(100) DEFAULT NULL AFTER date_of_birth');
        $this->ensureColumn($db, 'donors', 'township', 'VARCHAR(100) DEFAULT NULL AFTER state_region');
        $this->ensureColumn($db, 'users', 'next_available_date', 'DATETIME DEFAULT NULL');

        $this->migrated = true;
    }

    private function ensureColumn(PDO $db, string $table, string $column, string $definition): void
    {
        $stmt = $db->query("SHOW COLUMNS FROM {$table} LIKE '{$column}'");

        if ($stmt->rowCount() === 0) {
            $db->exec("ALTER TABLE {$table} ADD COLUMN {$column} {$definition}");
        }
    }
}
