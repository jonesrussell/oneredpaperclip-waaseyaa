<?php

declare(strict_types=1);

namespace OneRedPaperclip\Enum;

enum TradeStatus: string
{
    case PendingConfirmation = 'pending_confirmation';
    case Completed = 'completed';
    case Disputed = 'disputed';
}
