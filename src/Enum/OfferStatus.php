<?php

declare(strict_types=1);

namespace OneRedPaperclip\Enum;

enum OfferStatus: string
{
    case Pending = 'pending';
    case Accepted = 'accepted';
    case Declined = 'declined';
    case Withdrawn = 'withdrawn';
    case Expired = 'expired';
}
