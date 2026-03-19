<?php

declare(strict_types=1);

namespace OneRedPaperclip\Action;

use OneRedPaperclip\Entity\Challenge;
use OneRedPaperclip\Entity\Item;
use OneRedPaperclip\Entity\Offer;
use OneRedPaperclip\Enum\ItemRole;
use OneRedPaperclip\Enum\OfferStatus;
use Waaseyaa\EntityStorage\SqlEntityStorage;

final class CreateOffer
{
    public function __construct(
        private readonly SqlEntityStorage $offerStorage,
        private readonly SqlEntityStorage $itemStorage,
    ) {}

    /**
     * @param array{
     *     offered_item: array{title: string, description?: string},
     *     message?: string,
     * } $data
     */
    public function execute(int $fromUserId, Challenge $challenge, array $data): Offer
    {
        $offeredItem = new Item([
            'title' => $data['offered_item']['title'],
            'description' => $data['offered_item']['description'] ?? '',
            'role' => ItemRole::Offered->value,
            'itemable_type' => 'user',
            'itemable_id' => $fromUserId,
        ]);
        $this->itemStorage->save($offeredItem);

        $offer = new Offer([
            'from_user_id' => $fromUserId,
            'challenge_id' => $challenge->id(),
            'offered_item_id' => $offeredItem->id(),
            'for_challenge_item_id' => $challenge->getCurrentItemId(),
            'status' => OfferStatus::Pending->value,
            'message' => $data['message'] ?? '',
        ]);
        $this->offerStorage->save($offer);

        return $offer;
    }
}
