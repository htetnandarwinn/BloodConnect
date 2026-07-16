<?php

namespace App\BloodRequest\Domain\ValueObject;

/**
 * Immutable value object representing a blood group.
 *
 * Lenient by design: it normalizes the stored value (uppercase, trimmed)
 * but does not reject unknown formats, so it can wrap legacy data without
 * throwing. Equality is value-based.
 */
final class BloodGroup
{
    private string $value;

    public function __construct(string $value)
    {
        $this->value = strtoupper(trim($value));
    }

    public function getValue(): string
    {
        return $this->value;
    }

    public function isEmpty(): bool
    {
        return $this->value === '';
    }

    public function equals(BloodGroup $other): bool
    {
        return $this->value === $other->value;
    }

    public function __toString(): string
    {
        return $this->value;
    }
}
