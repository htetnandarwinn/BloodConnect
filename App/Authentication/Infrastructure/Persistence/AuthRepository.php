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

    // ================= FIND BY GOOGLE ID =================
    public function findByGoogleId(string $googleId)
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
                google_id,
                avatar,
                auth_provider
            FROM users
            WHERE google_id = :google_id
            LIMIT 1
        ");
        $stmt->execute([':google_id' => $googleId]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // ================= FIND BY EMAIL (with Google fields) =================
    public function findByEmailWithGoogle(string $email)
    {
        $stmt = $this->db->prepare("
            SELECT
                user_id,
                username,
                email,
                password,
                user_type_id,
                is_active,
                is_verified,
                google_id,
                avatar,
                auth_provider
            FROM users
            WHERE email = :email
            LIMIT 1
        ");
        $stmt->execute([':email' => $email]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // ================= CREATE GOOGLE USER =================
    public function createGoogleUser(
        string $username,
        string $email,
        string $googleId,
        string $avatar,
        int $userTypeId,
        int $statusId,
        string $bloodGroup = ''
    ): int {
        $stmt = $this->db->prepare("
            INSERT INTO users (
                username,
                email,
                google_id,
                avatar,
                auth_provider,
                user_type_id,
                status_id,
                blood_group,
                is_verified,
                is_active,
                available,
                created_at,
                updated_at
            ) VALUES (
                :username,
                :email,
                :google_id,
                :avatar,
                'google',
                :user_type_id,
                :status_id,
                :blood_group,
                1,
                1,
                1,
                NOW(),
                NOW()
            )
        ");
        $stmt->execute([
            ':username' => $username,
            ':email' => $email,
            ':blood_group' => $bloodGroup,
            ':google_id' => $googleId,
            ':avatar' => $avatar,
            ':user_type_id' => $userTypeId,
            ':status_id' => $statusId,
        ]);
        return (int)$this->db->lastInsertId();
    }

    // ================= LINK GOOGLE ACCOUNT TO EXISTING USER =================
    public function linkGoogleAccount(int $userId, string $googleId, string $avatar): bool
    {
        $stmt = $this->db->prepare("
            UPDATE users
            SET
                google_id = :google_id,
                avatar = :avatar,
                auth_provider = 'google'
            WHERE user_id = :user_id
        ");
        return $stmt->execute([
            ':google_id' => $googleId,
            ':avatar' => $avatar,
            ':user_id' => $userId,
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
