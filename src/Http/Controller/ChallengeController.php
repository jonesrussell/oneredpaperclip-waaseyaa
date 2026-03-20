<?php

declare(strict_types=1);

namespace OneRedPaperclip\Http\Controller;

use OneRedPaperclip\Action\CreateChallenge;
use OneRedPaperclip\Auth\AuthService;
use OneRedPaperclip\Entity\Challenge;
use OneRedPaperclip\Policy\ChallengePolicy;
use OneRedPaperclip\Validation\StoreChallengeValidator;
use Waaseyaa\EntityStorage\SqlEntityStorage;
use Waaseyaa\Inertia\Inertia;
use Waaseyaa\Inertia\InertiaResponse;

final class ChallengeController
{
    public function __construct(
        private readonly SqlEntityStorage $challengeStorage,
        private readonly SqlEntityStorage $itemStorage,
        private readonly SqlEntityStorage $categoryStorage,
        private readonly AuthService $auth,
    ) {}

    public function index(): InertiaResponse
    {
        $challenges = $this->challengeStorage->getQuery()
            ->condition('status', 'active')
            ->condition('visibility', 'public')
            ->execute();

        $loaded = [];
        foreach ($challenges as $id) {
            $challenge = $this->challengeStorage->load($id);
            if ($challenge instanceof Challenge) {
                $loaded[] = $challenge->toArray();
            }
        }

        $categories = [];
        $catIds = $this->categoryStorage->getQuery()->execute();
        foreach ($catIds as $catId) {
            $cat = $this->categoryStorage->load($catId);
            if ($cat !== null) {
                $categories[] = $cat->toArray();
            }
        }

        return Inertia::render('challenges/Index', [
            'challenges' => $loaded,
            'categories' => $categories,
        ]);
    }

    public function create(): InertiaResponse
    {
        $categories = [];
        $catIds = $this->categoryStorage->getQuery()->execute();
        foreach ($catIds as $catId) {
            $cat = $this->categoryStorage->load($catId);
            if ($cat !== null) {
                $categories[] = $cat->toArray();
            }
        }

        return Inertia::render('challenges/Create', [
            'categories' => $categories,
        ]);
    }

    /**
     * @param array<string, mixed> $data
     * @return InertiaResponse|array{errors: array<string, list<string>>}
     */
    public function store(array $data): InertiaResponse|array
    {
        $validator = new StoreChallengeValidator();
        $result = $validator->validate($data);

        if ($result->fails()) {
            return ['errors' => $result->errors()];
        }

        $user = $this->auth->currentUser();

        $action = new CreateChallenge($this->challengeStorage, $this->itemStorage);
        $challenge = $action->execute((int) $user->id(), $data);

        return Inertia::render('challenges/Show', [
            'challenge' => $challenge->toArray(),
        ]);
    }

    public function show(string $slug): InertiaResponse
    {
        $ids = $this->challengeStorage->getQuery()
            ->condition('slug', $slug)
            ->execute();

        if ($ids === []) {
            return Inertia::render('errors/NotFound', []);
        }

        $challenge = $this->challengeStorage->load(reset($ids));

        $currentItem = $challenge->getCurrentItemId()
            ? $this->itemStorage->load($challenge->getCurrentItemId())
            : null;

        $goalItem = $challenge->getGoalItemId()
            ? $this->itemStorage->load($challenge->getGoalItemId())
            : null;

        return Inertia::render('challenges/Show', [
            'challenge' => $challenge->toArray(),
            'currentItem' => $currentItem?->toArray(),
            'goalItem' => $goalItem?->toArray(),
        ]);
    }

    public function edit(string $slug): InertiaResponse
    {
        $ids = $this->challengeStorage->getQuery()
            ->condition('slug', $slug)
            ->execute();

        $challenge = $this->challengeStorage->load(reset($ids));

        $policy = new ChallengePolicy();
        $user = $this->auth->currentUser();

        if (!$policy->update((int) $user->id(), $challenge)) {
            return Inertia::render('errors/Forbidden', []);
        }

        return Inertia::render('challenges/Edit', [
            'challenge' => $challenge->toArray(),
        ]);
    }

    /**
     * @param array<string, mixed> $data
     */
    public function update(string $slug, array $data): InertiaResponse
    {
        $ids = $this->challengeStorage->getQuery()
            ->condition('slug', $slug)
            ->execute();

        $challenge = $this->challengeStorage->load(reset($ids));

        if (isset($data['title'])) {
            $challenge->setTitle($data['title']);
        }
        if (isset($data['status'])) {
            $challenge->setStatus(\OneRedPaperclip\Enum\ChallengeStatus::from($data['status']));
        }

        $this->challengeStorage->save($challenge);

        return Inertia::render('challenges/Show', [
            'challenge' => $challenge->toArray(),
        ]);
    }

    public function aiSuggest(): InertiaResponse
    {
        // Stub — AI suggestions deferred to P2.
        return Inertia::render('challenges/Create', []);
    }
}
