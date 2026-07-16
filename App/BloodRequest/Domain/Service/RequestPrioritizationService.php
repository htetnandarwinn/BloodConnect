<?php

namespace App\BloodRequest\Domain\Service;

use App\BloodRequest\Domain\ValueObject\Urgency;

/**
 * Encapsulates the blood-request prioritization business rule.
 *
 * Priority order (highest -> lowest):
 *   Critical (0) > Urgent (1) > Standard/Routine (2)
 *
 * Ties on the same urgency level are broken by creation time,
 * the earliest request taking precedence.
 *
 * The urgency rank mapping lives in the Urgency value object, which is the
 * single source of truth; this service delegates to it.
 *
 * This is a pure domain rule: no database access, no framework
 * dependencies, so it can be reused by any application use case.
 */
class RequestPrioritizationService
{
    public function rank(string $urgency): int
    {
        return (new Urgency($urgency))->rank();
    }

    public function isHigherPriority(string $a, string $b): bool
    {
        return (new Urgency($a))->isHigherPriorityThan(new Urgency($b));
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
