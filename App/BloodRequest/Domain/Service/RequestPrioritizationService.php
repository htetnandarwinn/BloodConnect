<?php

namespace App\BloodRequest\Domain\Service;

/**
 * Encapsulates the blood-request prioritization business rule.
 *
 * Priority order (highest -> lowest):
 *   Critical (0) > Urgent (1) > Standard/Routine (2)
 *
 * Ties on the same urgency level are broken by creation time,
 * the earliest request taking precedence.
 *
 * This is a pure domain rule: no database access, no framework
 * dependencies, so it can be reused by any application use case.
 */
class RequestPrioritizationService
{
    // Lower number means higher priority.
    private const URGENCY_RANK = [
        'CRITICAL' => 0,
        'URGENT'   => 1,
        'STANDARD' => 2,
        'ROUTINE'  => 2,
    ];

    private const DEFAULT_RANK = 2;

    public function rank(string $urgency): int
    {
        return self::URGENCY_RANK[strtoupper(trim($urgency))] ?? self::DEFAULT_RANK;
    }

    public function isHigherPriority(string $a, string $b): bool
    {
        return $this->rank($a) < $this->rank($b);
    }

    /**
     * Sort a list of request rows by priority.
     *
     * 1. Urgency rank ascending (Critical first).
     * 2. creation timestamp ascending (earliest first on a tie).
     *
     * @param array<int|string, array> $requests
     * @return array<int|string, array>
     */
    public function sortByPriority(array $requests): array
    {
        $decorated = [];
        foreach ($requests as $key => $request) {
            $decorated[$key] = [
                'request' => $request,
                'rank'    => $this->rank((string)($request['urgency'] ?? '')),
                'created' => (string)($request['created_at'] ?? ''),
            ];
        }

        uasort($decorated, function (array $x, array $y): int {
            if ($x['rank'] !== $y['rank']) {
                return $x['rank'] <=> $y['rank'];
            }
            return $x['created'] <=> $y['created'];
        });

        return array_map(static fn(array $item) => $item['request'], $decorated);
    }
}
