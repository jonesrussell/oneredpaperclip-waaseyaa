<?php

declare(strict_types=1);

namespace OneRedPaperclip\Service;

use OneRedPaperclip\Enum\ChallengeStatus;

/**
 * Defines valid challenge status transitions.
 *
 * Enforces the challenge lifecycle state machine.
 */
final class ChallengeWorkflow
{
    /**
     * @var array<string, list<string>> Allowed transitions: from => [to, ...]
     */
    private const array TRANSITIONS = [
        'draft' => ['active'],
        'active' => ['paused', 'completed', 'draft'],
        'paused' => ['active', 'draft'],
        'completed' => [],
    ];

    public function canTransition(ChallengeStatus $from, ChallengeStatus $to): bool
    {
        $allowed = self::TRANSITIONS[$from->value] ?? [];

        return \in_array($to->value, $allowed, true);
    }

    /**
     * @return list<ChallengeStatus>
     */
    public function allowedTransitions(ChallengeStatus $from): array
    {
        $allowed = self::TRANSITIONS[$from->value] ?? [];

        return array_map(
            fn (string $value) => ChallengeStatus::from($value),
            $allowed,
        );
    }

    /**
     * Validate and perform a transition, throwing on invalid.
     */
    public function transition(ChallengeStatus $from, ChallengeStatus $to): ChallengeStatus
    {
        if (!$this->canTransition($from, $to)) {
            throw new \InvalidArgumentException(
                "Cannot transition from '{$from->value}' to '{$to->value}'.",
            );
        }

        return $to;
    }
}
