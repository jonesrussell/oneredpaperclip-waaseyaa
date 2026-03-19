<?php

declare(strict_types=1);

namespace OneRedPaperclip\Tests\Unit\Enum;

use OneRedPaperclip\Enum\ItemRole;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

#[CoversClass(ItemRole::class)]
final class ItemRoleTest extends TestCase
{
    #[Test]
    public function hasExpectedCases(): void
    {
        $cases = array_map(fn ($c) => $c->value, ItemRole::cases());

        $this->assertSame(['start', 'goal', 'offered'], $cases);
    }
}
