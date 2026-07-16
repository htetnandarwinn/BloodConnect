<?php

namespace App\Donor\Domain\Entity;

use App\BloodRequest\Domain\ValueObject\BloodGroup;

/**
 * Rich domain entity for a donor.
 *
 * Repositories currently return plain arrays; this is the target model the
 * Donor module will adopt. It wraps the donor's blood group in a value object
 * and exposes behaviour rather than mutable public properties.
 */
class Donor
{
    public function __construct(
        private ?int $id,
        private string $name,
        private BloodGroup $bloodGroup,
        private ?float $weight = null,
        private ?string $dateOfBirth = null,
        private ?string $stateRegion = null,
        private ?string $township = null,
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

    public function getBloodGroup(): BloodGroup
    {
        return $this->bloodGroup;
    }

    public function getWeight(): ?float
    {
        return $this->weight;
    }

    public function getStateRegion(): ?string
    {
        return $this->stateRegion;
    }

    public function getTownship(): ?string
    {
        return $this->township;
    }

    public function matchesLocation(?string $stateRegion, ?string $township): bool
    {
        if ($stateRegion !== null && $this->stateRegion !== null
            && strcasecmp($this->stateRegion, $stateRegion) === 0) {
            return true;
        }

        return $township !== null && $this->township !== null
            && strcasecmp($this->township, $township) === 0;
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
            bloodGroup: new BloodGroup((string) ($row['blood_group'] ?? '')),
            weight: isset($row['weight']) ? (float) $row['weight'] : null,
            dateOfBirth: $row['date_of_birth'] ?? null,
            stateRegion: $row['state_region'] ?? null,
            township: $row['township'] ?? null,
            attributes: $row
        );
    }
}
