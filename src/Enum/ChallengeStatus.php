<?php

declare(strict_types=1);

namespace OneRedPaperclip\Enum;

enum ChallengeStatus: string
{
    case Draft = 'draft';
    case Active = 'active';
    case Completed = 'completed';
    case Paused = 'paused';
}
