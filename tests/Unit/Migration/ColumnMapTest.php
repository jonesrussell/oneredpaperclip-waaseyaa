<?php

declare(strict_types=1);

namespace OneRedPaperclip\Tests\Unit\Migration;

use OneRedPaperclip\Migration\ColumnMap;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

#[CoversClass(ColumnMap::class)]
final class ColumnMapTest extends TestCase
{
    #[Test]
    public function convertTimestampConvertsLaravelFormat(): void
    {
        $this->assertSame('2026-03-19T12:00:00Z', ColumnMap::convertTimestamp('2026-03-19 12:00:00'));
    }

    #[Test]
    public function convertTimestampPassesThroughIso8601(): void
    {
        $this->assertSame('2026-03-19T12:00:00Z', ColumnMap::convertTimestamp('2026-03-19T12:00:00Z'));
    }

    #[Test]
    public function convertTimestampReturnsNullForNull(): void
    {
        $this->assertNull(ColumnMap::convertTimestamp(null));
    }

    #[Test]
    public function convertTimestampReturnsNullForEmpty(): void
    {
        $this->assertNull(ColumnMap::convertTimestamp(''));
    }

    #[Test]
    public function tableToEntityTypeMapsAllTenTables(): void
    {
        $map = ColumnMap::tableToEntityType();

        $this->assertCount(10, $map);
        $this->assertSame('challenge', $map['challenges']);
        $this->assertSame('user', $map['users']);
        $this->assertSame('category', $map['categories']);
        $this->assertSame('media', $map['media']);
    }

    #[Test]
    public function labelSourcesDefinedForAllEntityTypes(): void
    {
        $sources = ColumnMap::labelSources();

        $this->assertSame('title', $sources['challenge']);
        $this->assertSame('name', $sources['user']);
        $this->assertSame('name', $sources['category']);
        $this->assertSame('file_name', $sources['media']);
        $this->assertSame('', $sources['offer']);
    }
}
