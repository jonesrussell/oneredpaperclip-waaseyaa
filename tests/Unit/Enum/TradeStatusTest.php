<?php

declare(strict_types=1);

namespace OneRedPaperclip\Tests\Unit\Enum;

use OneRedPaperclip\Enum\TradeStatus;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

#[CoversClass(TradeStatus::class)]
final class TradeStatusTest extends TestCase
{
    #[Test]
    public function hasExpectedCases(): void
    {
        $cases = array_map(fn ($c) => $c->value, TradeStatus::cases());

        $this->assertSame(['pending_confirmation', 'completed', 'disputed'], $cases);
    }
}
