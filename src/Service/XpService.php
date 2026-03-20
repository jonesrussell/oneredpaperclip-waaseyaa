<?php

declare(strict_types=1);

namespace OneRedPaperclip\Service;

use OneRedPaperclip\Entity\User;
use Waaseyaa\EntityStorage\SqlEntityStorage;

/**
 * Awards XP and manages level-ups.
 *
 * Matches Laravel's XpService constants and level formula.
 */
final class XpService
{
    public const int CREATE_CHALLENGE = 50;
    public const int RECEIVE_OFFER = 10;
    public const int COMPLETE_TRADE = 100;
    public const int COMPLETE_CHALLENGE = 500;
    public const int DAILY_LOGIN = 25;

    public function __construct(
        private readonly SqlEntityStorage $userStorage,
    ) {}

    public function award(User $user, int $baseAmount): int
    {
        $amount = $this->applyStreakMultiplier($user, $baseAmount);

        $newXp = $user->getXp() + $amount;
        $user->setXp($newXp);

        $newLevel = self::levelForXp($newXp);
        if ($newLevel > $user->getLevel()) {
            $user->setLevel($newLevel);
        }

        $this->userStorage->save($user);

        return $amount;
    }

    /**
     * Calculate XP required for a given level.
     *
     * Formula: 250 * level^1.5 (matches Laravel).
     */
    public static function xpRequiredForLevel(int $level): int
    {
        return (int) round(250 * ($level ** 1.5));
    }

    /**
     * Calculate the level for a given XP total.
     */
    public static function levelForXp(int $xp): int
    {
        $level = 1;

        while (self::xpRequiredForLevel($level + 1) <= $xp) {
            $level++;
        }

        return $level;
    }

    /**
     * Apply streak multiplier: amount * (1 + (streak - 1) * 0.1) for streak > 1.
     */
    private function applyStreakMultiplier(User $user, int $amount): int
    {
        $streak = $user->getCurrentStreak();

        if ($streak <= 1) {
            return $amount;
        }

        return (int) round($amount * (1 + ($streak - 1) * 0.1));
    }
}
