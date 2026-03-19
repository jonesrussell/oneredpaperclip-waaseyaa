<?php

declare(strict_types=1);

namespace OneRedPaperclip\Notification;

enum NotificationType: string
{
    case OfferReceived = 'offer_received';
    case OfferAccepted = 'offer_accepted';
    case OfferDeclined = 'offer_declined';
    case TradePendingConfirmation = 'trade_pending_confirmation';
    case TradeCompleted = 'trade_completed';
    case ChallengeCompleted = 'challenge_completed';
}
