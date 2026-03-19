<?php

declare(strict_types=1);

namespace OneRedPaperclip\Policy;

use OneRedPaperclip\Entity\Challenge;
use OneRedPaperclip\Entity\Offer;
use OneRedPaperclip\Entity\Trade;
use OneRedPaperclip\Enum\TradeStatus;

final class TradePolicy
{
    /**
     * Either the offerer or the challenge owner can confirm a trade.
     */
    public function confirm(int $userId, Trade $trade, Offer $offer, Challenge $challenge): bool
    {
        return $offer->getFromUserId() === $userId
            || $challenge->getUserId() === $userId;
    }

    /**
     * Only the challenge owner can update a trade, and it must be pending.
     */
    public function update(int $userId, Trade $trade, Challenge $challenge): bool
    {
        return $challenge->getUserId() === $userId
            && $trade->getStatus() === TradeStatus::PendingConfirmation;
    }
}
