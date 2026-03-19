<?php

declare(strict_types=1);

namespace OneRedPaperclip\Tests\Unit\Entity;

use OneRedPaperclip\Entity\Item;
use OneRedPaperclip\Enum\ItemRole;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

#[CoversClass(Item::class)]
final class ItemTest extends TestCase
{
    #[Test]
    public function entityTypeIdIsItem(): void
    {
        $item = new Item([]);

        $this->assertSame('item', $item->getEntityTypeId());
    }

    #[Test]
    public function newItemIsNew(): void
    {
        $item = new Item(['title' => 'Paperclip']);

        $this->assertTrue($item->isNew());
    }

    #[Test]
    public function labelReturnsTitle(): void
    {
        $item = new Item(['title' => 'Red Paperclip']);

        $this->assertSame('Red Paperclip', $item->label());
    }

    #[Test]
    public function getTitleReturnsTitle(): void
    {
        $item = new Item(['title' => 'Pen']);

        $this->assertSame('Pen', $item->getTitle());
    }

    #[Test]
    public function getRoleReturnsEnum(): void
    {
        $item = new Item(['title' => 'Pen', 'role' => 'start']);

        $this->assertSame(ItemRole::Start, $item->getRole());
    }

    #[Test]
    public function getRoleReturnsNullWhenNotSet(): void
    {
        $item = new Item(['title' => 'Pen']);

        $this->assertNull($item->getRole());
    }

    #[Test]
    public function getItemableTypeReturnsType(): void
    {
        $item = new Item(['title' => 'Pen', 'itemable_type' => 'challenge']);

        $this->assertSame('challenge', $item->getItemableType());
    }

    #[Test]
    public function getItemableIdReturnsId(): void
    {
        $item = new Item(['title' => 'Pen', 'itemable_id' => 5]);

        $this->assertSame(5, $item->getItemableId());
    }

    #[Test]
    public function getEstimatedValueReturnsValue(): void
    {
        $item = new Item(['title' => 'Pen', 'estimated_value' => '25.50']);

        $this->assertSame('25.50', $item->getEstimatedValue());
    }

    #[Test]
    public function getDescriptionReturnsEmptyStringByDefault(): void
    {
        $item = new Item(['title' => 'Pen']);

        $this->assertSame('', $item->getDescription());
    }

    #[Test]
    public function setTitleUpdatesTitle(): void
    {
        $item = new Item(['title' => 'Old']);
        $item->setTitle('New');

        $this->assertSame('New', $item->getTitle());
    }
}
