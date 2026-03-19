<?php

declare(strict_types=1);

namespace OneRedPaperclip\Tests\Unit\Enum;

use OneRedPaperclip\Enum\ChallengeVisibility;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

#[CoversClass(ChallengeVisibility::class)]
final class ChallengeVisibilityTest extends TestCase
{
    #[Test]
    public function hasExpectedCases(): void
    {
        $cases = array_map(fn ($c) => $c->value, ChallengeVisibility::cases());

        $this->assertSame(['public', 'private', 'unlisted'], $cases);
    }
}
