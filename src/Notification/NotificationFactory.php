<?php

declare(strict_types=1);

namespace OneRedPaperclip\Notification;

use OneRedPaperclip\Entity\Challenge;
use OneRedPaperclip\Entity\Notification;
use OneRedPaperclip\Entity\Offer;
use OneRedPaperclip\Entity\Trade;

final class NotificationFactory
{
    public function offerReceived(int $recipientUserId, Offer $offer, Challenge $challenge): Notification
    {
        return new Notification([
            'user_id' => $recipientUserId,
            'type' => NotificationType::OfferReceived->value,
            'data' => json_encode([
                'offer_id' => $offer->id(),
                'challenge_id' => $challenge->id(),
                'challenge_title' => $challenge->getTitle(),
                'from_user_id' => $offer->getFromUserId(),
            ]),
        ]);
    }

    public function offerAccepted(int $recipientUserId, Offer $offer, Trade $trade, Challenge $challenge): Notification
    {
        return new Notification([
            'user_id' => $recipientUserId,
            'type' => NotificationType::OfferAccepted->value,
            'data' => json_encode([
                'offer_id' => $offer->id(),
                'trade_id' => $trade->id(),
                'challenge_id' => $challenge->id(),
                'challenge_title' => $challenge->getTitle(),
            ]),
        ]);
    }

    public function offerDeclined(int $recipientUserId, Offer $offer, Challenge $challenge): Notification
    {
        return new Notification([
            'user_id' => $recipientUserId,
            'type' => NotificationType::OfferDeclined->value,
            'data' => json_encode([
                'offer_id' => $offer->id(),
                'challenge_id' => $challenge->id(),
                'challenge_title' => $challenge->getTitle(),
            ]),
        ]);
    }

    public function tradePendingConfirmation(int $recipientUserId, Trade $trade, Challenge $challenge, int $confirmedByUserId): Notification
    {
        return new Notification([
            'user_id' => $recipientUserId,
            'type' => NotificationType::TradePendingConfirmation->value,
            'data' => json_encode([
                'trade_id' => $trade->id(),
                'challenge_id' => $challenge->id(),
                'confirmed_by_user_id' => $confirmedByUserId,
            ]),
        ]);
    }

    public function tradeCompleted(int $recipientUserId, Trade $trade, Challenge $challenge): Notification
    {
        return new Notification([
            'user_id' => $recipientUserId,
            'type' => NotificationType::TradeCompleted->value,
            'data' => json_encode([
                'trade_id' => $trade->id(),
                'challenge_id' => $challenge->id(),
                'challenge_title' => $challenge->getTitle(),
            ]),
        ]);
    }

    public function challengeCompleted(int $recipientUserId, Challenge $challenge): Notification
    {
        return new Notification([
            'user_id' => $recipientUserId,
            'type' => NotificationType::ChallengeCompleted->value,
            'data' => json_encode([
                'challenge_id' => $challenge->id(),
                'challenge_title' => $challenge->getTitle(),
            ]),
        ]);
    }
}
