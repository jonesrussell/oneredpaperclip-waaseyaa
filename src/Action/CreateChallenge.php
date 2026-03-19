<?php

declare(strict_types=1);

namespace OneRedPaperclip\Action;

use OneRedPaperclip\Entity\Challenge;
use OneRedPaperclip\Entity\Item;
use OneRedPaperclip\Enum\ChallengeStatus;
use OneRedPaperclip\Enum\ChallengeVisibility;
use OneRedPaperclip\Enum\ItemRole;
use Waaseyaa\EntityStorage\SqlEntityStorage;

final class CreateChallenge
{
    public function __construct(
        private readonly SqlEntityStorage $challengeStorage,
        private readonly SqlEntityStorage $itemStorage,
    ) {}

    /**
     * @param array{
     *     title: string,
     *     slug: string,
     *     story?: string,
     *     category_id?: int,
     *     status?: string,
     *     visibility?: string,
     *     start_item: array{title: string, description?: string},
     *     goal_item: array{title: string, description?: string},
     * } $data
     */
    public function execute(int $userId, array $data): Challenge
    {
        $challenge = new Challenge([
            'title' => $data['title'],
            'slug' => $data['slug'],
            'story' => $data['story'] ?? '',
            'status' => $data['status'] ?? ChallengeStatus::Active->value,
            'visibility' => $data['visibility'] ?? ChallengeVisibility::Public->value,
            'user_id' => $userId,
            'category_id' => $data['category_id'] ?? null,
        ]);

        $this->challengeStorage->save($challenge);
        $challengeId = $challenge->id();

        $startItem = new Item([
            'title' => $data['start_item']['title'],
            'description' => $data['start_item']['description'] ?? '',
            'role' => ItemRole::Start->value,
            'itemable_type' => 'challenge',
            'itemable_id' => $challengeId,
        ]);
        $this->itemStorage->save($startItem);

        $goalItem = new Item([
            'title' => $data['goal_item']['title'],
            'description' => $data['goal_item']['description'] ?? '',
            'role' => ItemRole::Goal->value,
            'itemable_type' => 'challenge',
            'itemable_id' => $challengeId,
        ]);
        $this->itemStorage->save($goalItem);

        $challenge->setCurrentItemId((int) $startItem->id());
        $challenge->set('goal_item_id', $goalItem->id());
        $this->challengeStorage->save($challenge);

        return $challenge;
    }
}
