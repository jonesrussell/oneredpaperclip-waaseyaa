<?php

declare(strict_types=1);

namespace OneRedPaperclip\Enum;

enum ItemRole: string
{
    case Start = 'start';
    case Goal = 'goal';
    case Offered = 'offered';
}
