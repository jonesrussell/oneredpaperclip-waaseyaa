<?php

declare(strict_types=1);

namespace OneRedPaperclip\Policy;

use OneRedPaperclip\Entity\Challenge;

final class ChallengePolicy
{
    public function update(int $userId, Challenge $challenge): bool
    {
        return $challenge->getUserId() === $userId;
    }
}
