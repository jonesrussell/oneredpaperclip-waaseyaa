<?php

declare(strict_types=1);

namespace OneRedPaperclip\Tests\Unit\Enum;

use OneRedPaperclip\Enum\OfferStatus;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

#[CoversClass(OfferStatus::class)]
final class OfferStatusTest extends TestCase
{
    #[Test]
    public function hasExpectedCases(): void
    {
        $cases = array_map(fn ($c) => $c->value, OfferStatus::cases());

        $this->assertSame(['pending', 'accepted', 'declined', 'withdrawn', 'expired'], $cases);
    }
}
