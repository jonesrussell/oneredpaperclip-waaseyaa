<?php

declare(strict_types=1);

namespace OneRedPaperclip\Http\Controller;

use OneRedPaperclip\Auth\AuthService;
use OneRedPaperclip\Entity\Challenge;
use Waaseyaa\EntityStorage\SqlEntityStorage;
use Waaseyaa\Inertia\Inertia;
use Waaseyaa\Inertia\InertiaResponse;

final class DashboardController
{
    public function __construct(
        private readonly SqlEntityStorage $challengeStorage,
        private readonly AuthService $auth,
    ) {}

    public function challenges(): InertiaResponse
    {
        $user = $this->auth->currentUser();
        $ids = $this->challengeStorage->getQuery()
            ->condition('user_id', (int) $user->id())
            ->execute();

        $challenges = [];
        foreach ($ids as $id) {
            $c = $this->challengeStorage->load($id);
            if ($c instanceof Challenge) {
                $challenges[] = $c->toArray();
            }
        }

        return Inertia::render('dashboard/challenges/Index', [
            'challenges' => [
                'data' => $challenges,
                'current_page' => 1,
                'last_page' => 1,
                'links' => [],
            ],
        ]);
    }

    public function __invoke(): InertiaResponse
    {
        $user = $this->auth->currentUser();
        $ids = $this->challengeStorage->getQuery()
            ->condition('user_id', (int) $user->id())
            ->execute();

        $challenges = [];
        foreach ($ids as $id) {
            $c = $this->challengeStorage->load($id);
            if ($c instanceof Challenge) {
                $challenges[] = $c->toArray();
            }
        }

        return Inertia::render('Dashboard', [
            'challenges' => $challenges,
            'stats' => [
                'xp' => $user->getXp(),
                'level' => $user->getLevel(),
                'current_streak' => $user->getCurrentStreak(),
                'longest_streak' => $user->getLongestStreak(),
            ],
        ]);
    }
}
