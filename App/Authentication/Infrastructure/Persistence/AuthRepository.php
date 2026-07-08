<?php

namespace App\Authentication\Infrastructure\Persistence;

use App\Authentication\Domain\Repository\AuthRepositoryInterface;
use App\Authentication\Application\DTO\RegisterPatientDTO;
use App\Shared\Infrastructure\Database\Database;
use PDO;

class AuthRepository implements AuthRepositoryInterface
{
    private PDO $db;

    public function __construct()
    {
        $this->db = Database::getConnection();
    }

    // ================= FIND BY EMAIL =================
    public function findByEmail(string $email)
    {
        $stmt = $this->db->prepare("
        SELECT
            user_id,
            username,
            email,
            phone,
            blood_group,
            address,
            password,
            user_type_id,
            status_id,
            available,
            is_active,
            is_verified,
            verification_code,
            verification_expires_at
        FROM users
        WHERE email = :email
        LIMIT 1
    ");

        $stmt->execute([
            ':email' => $email
        ]);

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    // ================= FIND BY USERNAME =================
    public function findByUsername(string $username)
    {
        $stmt = $this->db->prepare("
        SELECT
            user_id,
            username,
            email,
            phone,
            blood_group,
            address,
            password,
            user_type_id,
            status_id,
            available,
            is_active,
            is_verified,
            verification_code,
            verification_expires_at
        FROM users
        WHERE username = :username
        LIMIT 1
    ");

        $stmt->execute([
            ':username' => $username
        ]);

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // ================= CREATE PATIENT =================
    public function createPatient(
        RegisterPatientDTO $dto,
        int $userTypeId,
        int $statusId,
        int $otp,
        string $expiresAt
    ): string {

        $sql = "
        INSERT INTO users (
            username,
            email,
            phone,
            password,
            blood_group,
            address,
            user_type_id,
            status_id,
            available,
            is_verified,
            verification_code,
            verification_expires_at,
            created_at,
            updated_at
        ) VALUES (
            :username,
            :email,
            :phone,
            :password,
            :blood_group,
            :address,
            :user_type_id,
            :status_id,
            1,
            0,
            :otp,
            :expiresAt,
            NOW(),
            NOW()
        )
        ";

        $stmt = $this->db->prepare($sql);

        $stmt->execute([
            ':username' => $dto->username,
            ':email' => $dto->email,
            ':phone' => $dto->phone,
            ':password' => password_hash($dto->password, PASSWORD_BCRYPT),
            ':blood_group' => $dto->blood_group,
            ':address' => $dto->address,
            ':user_type_id' => $userTypeId,
            ':status_id' => $statusId,
            ':otp' => $otp,
            ':expiresAt' => $expiresAt,
        ]);

        return (string) $this->db->lastInsertId();
    }

    // ================= CREATE DONOR =================
    public function createDonor(RegisterPatientDTO $dto)
    {
        $sql = "
            INSERT INTO users (
                username,
                email,
                phone,
                password,
                blood_group,
                address,
                user_type_id,
                status_id,
                available,
                created_at,
                updated_at
            ) VALUES (
                :username,
                :email,
                :phone,
                :password,
                :blood_group,
                :address,
                :user_type_id,
                :status_id,
                :available,
                NOW(),
                NOW()
            )
        ";

        $stmt = $this->db->prepare($sql);

        $stmt->execute([
            ':username' => $dto->username,
            ':email' => $dto->email,
            ':phone' => $dto->phone,
            ':password' => password_hash($dto->password, PASSWORD_BCRYPT),
            ':blood_group' => $dto->blood_group,
            ':address' => $dto->address,
            ':user_type_id' => 2,
            ':status_id' => 1,
            ':available' => 1
        ]);

        return $this->db->lastInsertId();
    }

    public function markAsVerified($userId)
    {
        $stmt = $this->db->prepare("
            UPDATE users
            SET
                is_verified = 1,
                verification_code = NULL,
                verification_expires_at = NULL
            WHERE user_id = :id
        ");

        $stmt->execute([
            ':id' => $userId
        ]);
    }

    public function updateVerificationCode($email, $code, $expires)
    {
        $stmt = $this->db->prepare("
            UPDATE users
            SET
                verification_code = :code,
                verification_expires_at = :expires
            WHERE email = :email
        ");

        $stmt->execute([
            ':code' => $code,
            ':expires' => $expires,
            ':email' => $email
        ]);
    }

    public function updatePassword(string $email, string $hashedPassword): void
    {
        $stmt = $this->db->prepare("
            UPDATE users
            SET
                password = :password,
                updated_at = NOW()
            WHERE email = :email
        ");

        $stmt->execute([
            ':password' => $hashedPassword,
            ':email' => $email
        ]);
    }

    public function clearVerificationCode(string $email): void
    {
        $stmt = $this->db->prepare("
            UPDATE users
            SET
                verification_code = NULL,
                verification_expires_at = NULL
            WHERE email = :email
        ");

        $stmt->execute([
            ':email' => $email
        ]);
    }

    public function getPermissionsByUserType(int $userTypeId): array
    {
        // Admin gets every permission
        if ($userTypeId === 1) {

            $stmt = $this->db->query("
            SELECT permission_key
            FROM permissions
        ");

            return $stmt->fetchAll(\PDO::FETCH_COLUMN);
        }

        $stmt = $this->db->prepare("
        SELECT p.permission_key
        FROM user_type_permissions utp
        INNER JOIN permissions p
            ON p.permission_id = utp.permission_id
        WHERE utp.user_type_id = ?
    ");

        $stmt->execute([$userTypeId]);

        return $stmt->fetchAll(\PDO::FETCH_COLUMN);
    }
}
