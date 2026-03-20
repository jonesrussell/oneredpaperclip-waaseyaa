<?php

declare(strict_types=1);

namespace OneRedPaperclip\Service;

use OneRedPaperclip\Entity\User;
use Waaseyaa\EntityStorage\SqlEntityStorage;

/**
 * Manages daily login streaks.
 */
final class StreakService
{
    public function __construct(
        private readonly SqlEntityStorage $userStorage,
    ) {}

    /**
     * Record a daily activity. Increments streak if last activity was
     * yesterday, resets to 1 if more than a day gap, no-op if same day.
     */
    public function recordActivity(User $user, string $now): void
    {
        $lastActivity = $user->getLastActivityAt();

        if ($lastActivity === null) {
            $user->set('current_streak', 1);
            $user->set('longest_streak', 1);
            $user->set('last_activity_at', $now);
            $this->userStorage->save($user);

            return;
        }

        $lastDate = substr($lastActivity, 0, 10);
        $nowDate = substr($now, 0, 10);

        if ($lastDate === $nowDate) {
            return;
        }

        $lastTs = strtotime($lastDate);
        $nowTs = strtotime($nowDate);
        $daysDiff = (int) (($nowTs - $lastTs) / 86400);

        if ($daysDiff === 1) {
            $newStreak = $user->getCurrentStreak() + 1;
            $user->set('current_streak', $newStreak);

            if ($newStreak > $user->getLongestStreak()) {
                $user->set('longest_streak', $newStreak);
            }
        } else {
            $user->set('current_streak', 1);
        }

        $user->set('last_activity_at', $now);
        $this->userStorage->save($user);
    }
}
