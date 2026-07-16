<?php

namespace App\BloodRequest\Domain\Entity;

use App\BloodRequest\Domain\ValueObject\BloodGroup;
use App\BloodRequest\Domain\ValueObject\RequestStatus;
use App\BloodRequest\Domain\ValueObject\Urgency;
use DateTimeImmutable;

/**
 * Rich domain entity for a blood request.
 *
 * Currently repositories return plain arrays; this entity is the target model
 * that the BloodRequest module will adopt. It holds domain value objects and
 * exposes behavior instead of exposing mutable public properties.
 */
final class BloodRequest
{
    public function __construct(
        private ?int $id,
        private BloodGroup $bloodGroup,
        private Urgency $urgency,
        private RequestStatus $status,
        private ?int $patientId,
        private ?int $donorId,
        private ?string $township,
        private ?string $stateRegion,
        private ?DateTimeImmutable $createdAt,
        private array $attributes = []
    ) {
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getBloodGroup(): BloodGroup
    {
        return $this->bloodGroup;
    }

    public function getUrgency(): Urgency
    {
        return $this->urgency;
    }

    public function getStatus(): RequestStatus
    {
        return $this->status;
    }

    public function getPatientId(): ?int
    {
        return $this->patientId;
    }

    public function getDonorId(): ?int
    {
        return $this->donorId;
    }

    public function getTownship(): ?string
    {
        return $this->township;
    }

    public function getStateRegion(): ?string
    {
        return $this->stateRegion;
    }

    public function getCreatedAt(): ?DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function getAttribute(string $key, $default = null)
    {
        return $this->attributes[$key] ?? $default;
    }

    public function isPending(int $pendingStatusId): bool
    {
        return $this->status->is($pendingStatusId);
    }

    public function isAccepted(int $acceptedStatusId): bool
    {
        return $this->status->is($acceptedStatusId);
    }

    public function isCancelled(int $cancelledStatusId): bool
    {
        return $this->status->is($cancelledStatusId);
    }

    /**
     * A request still needs a donor when it is pending and unassigned.
     */
    public function needsDonor(int $pendingStatusId): bool
    {
        return $this->isPending($pendingStatusId) && $this->donorId === null;
    }

    public function urgencyRank(): int
    {
        return $this->urgency->rank();
    }

    /**
     * Higher priority = lower rank; ties broken by earlier creation time.
     */
    public function isHigherPriorityThan(BloodRequest $other): bool
    {
        $rank = $this->urgencyRank();
        $otherRank = $other->urgencyRank();

        if ($rank !== $otherRank) {
            return $rank < $otherRank;
        }

        if ($this->createdAt === null || $other->createdAt === null) {
            return false;
        }

        return $this->createdAt < $other->createdAt;
    }

    /**
     * Builds an entity from a repository row (array), tolerating missing keys.
     */
    public static function fromArray(array $row): self
    {
        $createdAt = null;
        if (!empty($row['created_at'])) {
            $parsed = DateTimeImmutable::createFromFormat('Y-m-d H:i:s', $row['created_at'])
                ?? DateTimeImmutable::createFromFormat('Y-m-d H:i:s.u', $row['created_at']);
            $createdAt = $parsed ?: null;
        }

        $statusId = (int) ($row['status'] ?? $row['status_id'] ?? 0);
        $statusLabel = (string) ($row['status_label'] ?? '');

        return new self(
            id: isset($row['id']) ? (int) $row['id'] : null,
            bloodGroup: new BloodGroup((string) ($row['blood_group_needed'] ?? $row['blood_group'] ?? '')),
            urgency: new Urgency((string) ($row['urgency'] ?? '')),
            status: new RequestStatus($statusId, $statusLabel),
            patientId: isset($row['patient_id']) ? (int) $row['patient_id'] : null,
            donorId: isset($row['donor_id']) ? (int) $row['donor_id'] : null,
            township: $row['township'] ?? ($row['township_id'] ?? null),
            stateRegion: $row['state_region'] ?? ($row['state_region_id'] ?? null),
            createdAt: $createdAt,
            attributes: $row
        );
    }
}
