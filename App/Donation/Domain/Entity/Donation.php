<?php

namespace App\Donation\Domain\Entity;

use DateTimeImmutable;

/**
 * Rich domain entity for a completed blood donation.
 *
 * Repositories currently return plain arrays; this is the target model the
 * Donation module will adopt. It holds typed properties and exposes behaviour
 * instead of exposing mutable public properties.
 */
class Donation
{
    public function __construct(
        private ?int $id,
        private ?int $donorId,
        private ?int $requestId,
        private ?string $hospital,
        private ?float $volumeMl,
        private ?DateTimeImmutable $donatedAt,
        private array $attributes = []
    ) {
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDonorId(): ?int
    {
        return $this->donorId;
    }

    public function getRequestId(): ?int
    {
        return $this->requestId;
    }

    public function getHospital(): ?string
    {
        return $this->hospital;
    }

    public function getVolumeMl(): ?float
    {
        return $this->volumeMl;
    }

    public function getDonatedAt(): ?DateTimeImmutable
    {
        return $this->donatedAt;
    }

    public function isAssociatedWithRequest(int $requestId): bool
    {
        return $this->requestId !== null && $this->requestId === $requestId;
    }

    public function getAttribute(string $key, $default = null)
    {
        return $this->attributes[$key] ?? $default;
    }

    public static function fromArray(array $row): self
    {
        $donatedAt = null;
        if (!empty($row['donation_date'])) {
            $parsed = DateTimeImmutable::createFromFormat('Y-m-d H:i:s', $row['donation_date'])
                ?? DateTimeImmutable::createFromFormat('Y-m-d', $row['donation_date']);
            $donatedAt = $parsed ?: null;
        }

        return new self(
            id: isset($row['donation_id']) ? (int) $row['donation_id'] : (isset($row['id']) ? (int) $row['id'] : null),
            donorId: isset($row['donor_id']) ? (int) $row['donor_id'] : null,
            requestId: isset($row['request_id']) ? (int) $row['request_id'] : null,
            hospital: $row['hospital_name'] ?? null,
            volumeMl: isset($row['volume_ml']) ? (float) $row['volume_ml'] : null,
            donatedAt: $donatedAt,
            attributes: $row
        );
    }
}
