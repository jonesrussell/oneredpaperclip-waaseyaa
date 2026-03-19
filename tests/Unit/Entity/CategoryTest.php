<?php

declare(strict_types=1);

namespace OneRedPaperclip\Tests\Unit\Entity;

use OneRedPaperclip\Entity\Category;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

#[CoversClass(Category::class)]
final class CategoryTest extends TestCase
{
    #[Test]
    public function entityTypeIdIsCategory(): void
    {
        $category = new Category(['name' => 'Electronics']);

        $this->assertSame('category', $category->getEntityTypeId());
    }

    #[Test]
    public function labelReturnsName(): void
    {
        $category = new Category(['name' => 'Electronics']);

        $this->assertSame('Electronics', $category->label());
    }

    #[Test]
    public function getNameReturnsName(): void
    {
        $category = new Category(['name' => 'Books']);

        $this->assertSame('Books', $category->getName());
    }

    #[Test]
    public function setNameUpdatesName(): void
    {
        $category = new Category(['name' => 'Old']);
        $category->setName('New');

        $this->assertSame('New', $category->getName());
    }

    #[Test]
    public function getSlugReturnsSlug(): void
    {
        $category = new Category(['name' => 'Electronics', 'slug' => 'electronics']);

        $this->assertSame('electronics', $category->getSlug());
    }

    #[Test]
    public function setSlugUpdatesSlug(): void
    {
        $category = new Category(['name' => 'Test', 'slug' => 'old']);
        $category->setSlug('new');

        $this->assertSame('new', $category->getSlug());
    }
}
