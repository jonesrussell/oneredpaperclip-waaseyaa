<?php

declare(strict_types=1);

namespace OneRedPaperclip\Enum;

enum ChallengeVisibility: string
{
    case Public = 'public';
    case Private = 'private';
    case Unlisted = 'unlisted';
}
