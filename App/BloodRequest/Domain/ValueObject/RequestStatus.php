<?php

namespace App\BloodRequest\Domain\ValueObject;

/**
 * Immutable value object wrapping a request status (id + human label).
 *
 * Status ids are resolved from master_data at runtime and therefore are not
 * hard-coded here. Use is()/equals() for comparisons.
 */
final class RequestStatus
{
    public function __construct(
        private int $id,
        private string $label
    ) {
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getLabel(): string
    {
        return $this->label;
    }

    public function is(int $statusId): bool
    {
        return $this->id === $statusId;
    }

    public function equals(RequestStatus $other): bool
    {
        return $this->id === $other->id;
    }
}
