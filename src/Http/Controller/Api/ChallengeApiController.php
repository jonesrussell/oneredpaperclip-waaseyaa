<?php

declare(strict_types=1);

namespace OneRedPaperclip\Http\Controller\Api;

use OneRedPaperclip\Auth\AuthService;
use OneRedPaperclip\Entity\Challenge;
use Waaseyaa\EntityStorage\SqlEntityStorage;

final class ChallengeApiController
{
    public function __construct(
        private readonly SqlEntityStorage $challengeStorage,
        private readonly AuthService $auth,
    ) {}

    /** @return array{data: list<array<string, mixed>>} */
    public function index(): array
    {
        $ids = $this->challengeStorage->getQuery()
            ->condition('status', 'active')
            ->condition('visibility', 'public')
            ->execute();

        $data = [];
        foreach ($ids as $id) {
            $c = $this->challengeStorage->load($id);
            if ($c instanceof Challenge) {
                $data[] = $c->toArray();
            }
        }

        return ['data' => $data];
    }

    /** @return array{data: array<string, mixed>}|array{error: string} */
    public function show(int $id): array
    {
        $challenge = $this->challengeStorage->load($id);

        if (!$challenge instanceof Challenge) {
            return ['error' => 'Not found'];
        }

        return ['data' => $challenge->toArray()];
    }

    /** @return array{data: list<array<string, mixed>>} */
    public function mine(): array
    {
        $user = $this->auth->currentUser();

        if ($user === null) {
            return ['data' => []];
        }

        $ids = $this->challengeStorage->getQuery()
            ->condition('user_id', (int) $user->id())
            ->execute();

        $data = [];
        foreach ($ids as $id) {
            $c = $this->challengeStorage->load($id);
            if ($c instanceof Challenge) {
                $data[] = $c->toArray();
            }
        }

        return ['data' => $data];
    }
}
