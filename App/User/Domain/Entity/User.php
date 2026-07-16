<?php

namespace App\User\Domain\Entity;

/**
 * Rich domain entity for an application user (patient/donor/admin).
 *
 * Repositories currently return plain arrays; this is the target model the
 * User module will adopt. It holds typed properties and exposes behaviour
 * instead of exposing mutable public properties.
 */
class User
{
    public function __construct(
        private ?int $id,
        private string $name,
        private string $email,
        private ?string $role = null,
        private ?string $status = null,
        private array $attributes = []
    ) {
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getRole(): ?string
    {
        return $this->role;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function isActive(): bool
    {
        return $this->status === null || strtolower($this->status) === 'active';
    }

    public function hasRole(string $role): bool
    {
        return $this->role !== null && strcasecmp($this->role, $role) === 0;
    }

    public function getInitials(): string
    {
        $parts = preg_split('/\s+/', trim($this->name)) ?: [];

        if (count($parts) === 0) {
            return '';
        }

        $initials = strtoupper(substr($parts[0], 0, 1));
        if (count($parts) > 1) {
            $initials .= strtoupper(substr(end($parts), 0, 1));
        }

        return $initials;
    }

    public function getAttribute(string $key, $default = null)
    {
        return $this->attributes[$key] ?? $default;
    }

    public static function fromArray(array $row): self
    {
        return new self(
            id: isset($row['user_id']) ? (int) $row['user_id'] : (isset($row['id']) ? (int) $row['id'] : null),
            name: (string) ($row['username'] ?? $row['name'] ?? ''),
            email: (string) ($row['email'] ?? ''),
            role: $row['role'] ?? ($row['role_name'] ?? null),
            status: $row['status'] ?? ($row['status_name'] ?? null),
            attributes: $row
        );
    }
}
