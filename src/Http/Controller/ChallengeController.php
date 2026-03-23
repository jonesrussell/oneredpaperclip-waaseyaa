<?php

declare(strict_types=1);

namespace OneRedPaperclip\Http\Controller;

use OneRedPaperclip\Action\CreateChallenge;
use OneRedPaperclip\Auth\AuthService;
use OneRedPaperclip\Entity\Challenge;
use OneRedPaperclip\Entity\Item;
use OneRedPaperclip\Entity\Media;
use OneRedPaperclip\Entity\Offer;
use OneRedPaperclip\Entity\Trade;
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
        private readonly SqlEntityStorage $userStorage,
        private readonly SqlEntityStorage $tradeStorage,
        private readonly SqlEntityStorage $offerStorage,
        private readonly SqlEntityStorage $mediaStorage,
        private readonly AuthService $auth,
    ) {}

    /** @return array<string, mixed>|null */
    private function loadItemWithImage(int $itemId): ?array
    {
        $item = $this->itemStorage->load($itemId);
        if (!$item instanceof Item) {
            return null;
        }

        $data = $item->toArray();

        $mediaIds = $this->mediaStorage->getQuery()
            ->condition('model_type', 'App\Models\Item')
            ->condition('model_id', $itemId)
            ->execute();

        if ($mediaIds !== []) {
            $media = $this->mediaStorage->load(reset($mediaIds));
            if ($media instanceof Media) {
                $data['image_url'] = '/storage/' . $media->getPath();
            }
        }

        return $data;
    }

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
            ? $this->loadItemWithImage($challenge->getCurrentItemId())
            : null;

        $goalItem = $challenge->getGoalItemId()
            ? $this->loadItemWithImage($challenge->getGoalItemId())
            : null;

        $challengeData = $challenge->toArray();
        if ($challenge->getUserId() !== null) {
            $user = $this->userStorage->load($challenge->getUserId());
            if ($user !== null) {
                $challengeData['user'] = $user->toArray();
            }
        }

        $tradeIds = $this->tradeStorage->getQuery()
            ->condition('challenge_id', (int) $challenge->id())
            ->execute();
        $trades = [];
        foreach ($tradeIds as $tradeId) {
            $trade = $this->tradeStorage->load($tradeId);
            if ($trade instanceof Trade) {
                $tradeData = $trade->toArray();
                $tradeData['offered_item'] = $trade->getOfferedItemId()
                    ? $this->loadItemWithImage($trade->getOfferedItemId())
                    : null;
                $tradeData['owner_confirmed'] = $trade->getConfirmedByOwnerAt() !== null;
                $tradeData['offerer_confirmed'] = $trade->getConfirmedByOffererAt() !== null;

                // Load offerer from the related offer
                if ($trade->getOfferId() !== null) {
                    $relatedOffer = $this->offerStorage->load($trade->getOfferId());
                    if ($relatedOffer instanceof Offer && $relatedOffer->getFromUserId() !== null) {
                        $offerer = $this->userStorage->load($relatedOffer->getFromUserId());
                        $tradeData['offerer'] = $offerer !== null
                            ? ['id' => (int) $offerer->id(), 'name' => $offerer->get('name')]
                            : null;
                    }
                }

                $trades[] = $tradeData;
            }
        }
        $challengeData['trades'] = $trades;

        $offerIds = $this->offerStorage->getQuery()
            ->condition('challenge_id', (int) $challenge->id())
            ->execute();
        $offers = [];
        foreach ($offerIds as $offerId) {
            $offer = $this->offerStorage->load($offerId);
            if ($offer instanceof Offer) {
                $offerData = $offer->toArray();
                $offerData['offered_item'] = $offer->getOfferedItemId()
                    ? $this->loadItemWithImage($offer->getOfferedItemId())
                    : null;

                if ($offer->getFromUserId() !== null) {
                    $fromUser = $this->userStorage->load($offer->getFromUserId());
                    $offerData['from_user'] = $fromUser !== null
                        ? ['id' => (int) $fromUser->id(), 'name' => $fromUser->get('name')]
                        : null;
                }

                $offers[] = $offerData;
            }
        }
        $challengeData['offers'] = $offers;

        return Inertia::render('challenges/Show', [
            'challenge' => $challengeData,
            'currentItem' => $currentItem,
            'goalItem' => $goalItem,
            'isFollowing' => false,
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
