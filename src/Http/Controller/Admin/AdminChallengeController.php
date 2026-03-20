<?php

declare(strict_types=1);

namespace OneRedPaperclip\Http\Controller\Admin;

use OneRedPaperclip\Entity\Challenge;
use OneRedPaperclip\Enum\ChallengeStatus;
use Waaseyaa\EntityStorage\SqlEntityStorage;
use Waaseyaa\Inertia\Inertia;
use Waaseyaa\Inertia\InertiaResponse;

final class AdminChallengeController
{
    public function __construct(
        private readonly SqlEntityStorage $challengeStorage,
    ) {}

    public function index(): InertiaResponse
    {
        $ids = $this->challengeStorage->getQuery()->execute();
        $challenges = [];
        foreach ($ids as $id) {
            $c = $this->challengeStorage->load($id);
            if ($c instanceof Challenge) {
                $challenges[] = $c->toArray();
            }
        }

        return Inertia::render('dashboard/admin/challenges/Index', [
            'challenges' => $challenges,
        ]);
    }

    public function show(int $id): InertiaResponse
    {
        $challenge = $this->challengeStorage->load($id);

        return Inertia::render('dashboard/admin/challenges/Show', [
            'challenge' => $challenge?->toArray(),
        ]);
    }

    public function trashed(): InertiaResponse
    {
        $ids = $this->challengeStorage->getQuery()
            ->condition('deleted_at', null, 'IS NOT NULL')
            ->execute();

        $challenges = [];
        foreach ($ids as $id) {
            $c = $this->challengeStorage->load($id);
            if ($c instanceof Challenge) {
                $challenges[] = $c->toArray();
            }
        }

        return Inertia::render('dashboard/admin/challenges/Trashed', [
            'challenges' => $challenges,
        ]);
    }

    public function unpublish(int $id): InertiaResponse
    {
        $challenge = $this->challengeStorage->load($id);
        if ($challenge instanceof Challenge) {
            $challenge->setStatus(ChallengeStatus::Draft);
            $this->challengeStorage->save($challenge);
        }

        return $this->index();
    }

    public function destroy(int $id): InertiaResponse
    {
        $challenge = $this->challengeStorage->load($id);
        if ($challenge instanceof Challenge) {
            $challenge->set('deleted_at', date('Y-m-d\TH:i:s\Z'));
            $this->challengeStorage->save($challenge);
        }

        return $this->index();
    }

    public function restore(int $id): InertiaResponse
    {
        $challenge = $this->challengeStorage->load($id);
        if ($challenge instanceof Challenge) {
            $challenge->set('deleted_at', null);
            $this->challengeStorage->save($challenge);
        }

        return $this->trashed();
    }

    /**
     * @param array{ids: list<int>} $data
     */
    public function bulkUnpublish(array $data): InertiaResponse
    {
        foreach ($data['ids'] ?? [] as $id) {
            $challenge = $this->challengeStorage->load($id);
            if ($challenge instanceof Challenge) {
                $challenge->setStatus(ChallengeStatus::Draft);
                $this->challengeStorage->save($challenge);
            }
        }

        return $this->index();
    }

    /**
     * @param array{ids: list<int>} $data
     */
    public function bulkDelete(array $data): InertiaResponse
    {
        $now = date('Y-m-d\TH:i:s\Z');
        foreach ($data['ids'] ?? [] as $id) {
            $challenge = $this->challengeStorage->load($id);
            if ($challenge instanceof Challenge) {
                $challenge->set('deleted_at', $now);
                $this->challengeStorage->save($challenge);
            }
        }

        return $this->index();
    }
}
