<?php

declare(strict_types=1);

namespace OneRedPaperclip\Tests\Unit\Enum;

use OneRedPaperclip\Enum\ChallengeStatus;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

#[CoversClass(ChallengeStatus::class)]
final class ChallengeStatusTest extends TestCase
{
    #[Test]
    public function hasExpectedCases(): void
    {
        $cases = array_map(fn ($c) => $c->value, ChallengeStatus::cases());

        $this->assertSame(['draft', 'active', 'completed', 'paused'], $cases);
    }

    #[Test]
    public function canBeCreatedFromValue(): void
    {
        $this->assertSame(ChallengeStatus::Active, ChallengeStatus::from('active'));
    }
}
