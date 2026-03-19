<?php

declare(strict_types=1);

namespace OneRedPaperclip\Policy;

use OneRedPaperclip\Entity\Challenge;
use OneRedPaperclip\Entity\Offer;
use OneRedPaperclip\Enum\OfferStatus;

final class OfferPolicy
{
    /**
     * Owner cannot make offers on their own challenge.
     */
    public function create(int $userId, Challenge $challenge): bool
    {
        return $challenge->getUserId() !== $userId;
    }

    /**
     * Only the challenge owner can accept, offer must be pending,
     * and the offer's target item must match the challenge's current item.
     */
    public function accept(int $userId, Offer $offer, Challenge $challenge): bool
    {
        return $challenge->getUserId() === $userId
            && $offer->getStatus() === OfferStatus::Pending
            && $offer->getForChallengeItemId() === $challenge->getCurrentItemId();
    }

    /**
     * Only the challenge owner can decline, and offer must be pending.
     */
    public function decline(int $userId, Offer $offer, Challenge $challenge): bool
    {
        return $challenge->getUserId() === $userId
            && $offer->getStatus() === OfferStatus::Pending;
    }
}
