<?php

namespace App\BloodRequest\Domain\ValueObject;

use InvalidArgumentException;

/**
 * Immutable value object encapsulating request urgency and its priority rank.
 *
 * This is the single source of truth for urgency ranking. The mapping must
 * stay consistent with the business rule that drives donor reservation:
 *   Critical(0) > Urgent(1) > Standard / Routine(2)
 * with ties broken by creation time (handled by the caller).
 */
final class Urgency
{
    public const CRITICAL = 'CRITICAL';
    public const URGENT = 'URGENT';
    public const STANDARD = 'STANDARD';
    public const ROUTINE = 'ROUTINE';

    private const RANK = [
        self::CRITICAL => 0,
        self::URGENT => 1,
        self::STANDARD => 2,
        self::ROUTINE => 2,
    ];

    private const DEFAULT_RANK = 2;

    private string $value;

    public function __construct(string $value)
    {
        $normalized = strtoupper(trim($value));
        if ($normalized === '') {
            throw new InvalidArgumentException('Urgency cannot be empty.');
        }
        $this->value = $normalized;
    }

    public function getValue(): string
    {
        return $this->value;
    }

    /**
     * Lower rank means higher priority.
     */
    public function rank(): int
    {
        return self::RANK[$this->value] ?? self::DEFAULT_RANK;
    }

    public function isHigherPriorityThan(Urgency $other): bool
    {
        return $this->rank() < $other->rank();
    }

    public function equals(Urgency $other): bool
    {
        return $this->value === $other->value;
    }

    public function __toString(): string
    {
        return $this->value;
    }
}
