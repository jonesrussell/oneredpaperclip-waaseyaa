<?php

declare(strict_types=1);

namespace OneRedPaperclip\Enum;

enum ChallengeStatus: string
{
    case Draft = 'draft';
    case Published = 'published';
    case Completed = 'completed';
    case Archived = 'archived';
}
