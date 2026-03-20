<?php

declare(strict_types=1);

namespace OneRedPaperclip\Http\Controller;

use OneRedPaperclip\Entity\Challenge;
use OneRedPaperclip\Entity\Item;
use OneRedPaperclip\Entity\Media;
use Waaseyaa\EntityStorage\SqlEntityStorage;
use Waaseyaa\Inertia\Inertia;
use Waaseyaa\Inertia\InertiaResponse;

final class PageController
{
    public function __construct(
        private readonly SqlEntityStorage $challengeStorage,
        private readonly SqlEntityStorage $tradeStorage,
        private readonly SqlEntityStorage $userStorage,
        private readonly SqlEntityStorage $itemStorage,
        private readonly SqlEntityStorage $mediaStorage,
    ) {}

    public function home(): InertiaResponse
    {
        $challengeIds = $this->challengeStorage->getQuery()
            ->condition('status', 'active')
            ->condition('visibility', 'public')
            ->execute();

        $featuredChallenges = [];
        foreach ($challengeIds as $id) {
            $c = $this->challengeStorage->load($id);
            if ($c instanceof Challenge) {
                $data = $c->toArray();
                $data['current_item'] = $this->loadItemWithImage($c->getCurrentItemId());
                $data['goal_item'] = $this->loadItemWithImage($c->getGoalItemId());
                $featuredChallenges[] = $data;
            }
        }

        $allChallengeIds = $this->challengeStorage->getQuery()
            ->condition('status', 'active')
            ->condition('visibility', 'public')
            ->execute();
        $tradeIds = $this->tradeStorage->getQuery()->execute();
        $userIds = $this->userStorage->getQuery()->execute();

        return Inertia::render('Welcome', [
            'canRegister' => true,
            'featuredChallenges' => $featuredChallenges,
            'stats' => [
                'challengesCount' => \count($allChallengeIds),
                'tradesCount' => \count($tradeIds),
                'usersCount' => \count($userIds),
            ],
            'meta' => [
                'title' => 'One Red Paperclip — Trade up from one thing to something better',
                'description' => 'Trade up from a red paperclip to your dream item.',
            ],
        ]);
    }

    public function about(): InertiaResponse
    {
        return Inertia::render('About', [
            'meta' => [
                'title' => 'About — One Red Paperclip',
                'description' => 'Learn about the One Red Paperclip trade-up platform.',
            ],
        ]);
    }

    /** @return array<string, mixed>|null */
    private function loadItemWithImage(?int $itemId): ?array
    {
        if ($itemId === null) {
            return null;
        }

        $item = $this->itemStorage->load($itemId);

        if (!$item instanceof Item) {
            return null;
        }

        $data = $item->toArray();

        // Find media for this item.
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
}
