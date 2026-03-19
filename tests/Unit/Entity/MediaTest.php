<?php

declare(strict_types=1);

namespace OneRedPaperclip\Tests\Unit\Entity;

use OneRedPaperclip\Entity\Media;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

#[CoversClass(Media::class)]
final class MediaTest extends TestCase
{
    #[Test]
    public function entityTypeIdIsMedia(): void
    {
        $media = new Media([]);

        $this->assertSame('media', $media->getEntityTypeId());
    }

    #[Test]
    public function labelReturnsFileNameWhenSet(): void
    {
        $media = new Media(['file_name' => 'photo.jpg']);

        $this->assertSame('photo.jpg', $media->label());
    }

    #[Test]
    public function labelReturnsFallbackWhenNoFileName(): void
    {
        $media = new Media([]);

        $this->assertSame('Media #new', $media->label());
    }

    #[Test]
    public function getModelTypeReturnsType(): void
    {
        $media = new Media(['model_type' => 'item']);

        $this->assertSame('item', $media->getModelType());
    }

    #[Test]
    public function getModelIdReturnsId(): void
    {
        $media = new Media(['model_id' => 42]);

        $this->assertSame(42, $media->getModelId());
    }

    #[Test]
    public function getCollectionNameReturnsNull(): void
    {
        $media = new Media([]);

        $this->assertNull($media->getCollectionName());
    }

    #[Test]
    public function getFileNameReturnsFileName(): void
    {
        $media = new Media(['file_name' => 'avatar.png']);

        $this->assertSame('avatar.png', $media->getFileName());
    }

    #[Test]
    public function getDiskReturnsDisk(): void
    {
        $media = new Media(['disk' => 'public']);

        $this->assertSame('public', $media->getDisk());
    }

    #[Test]
    public function getPathReturnsPath(): void
    {
        $media = new Media(['path' => 'uploads/items/photo.jpg']);

        $this->assertSame('uploads/items/photo.jpg', $media->getPath());
    }

    #[Test]
    public function getSizeReturnsSize(): void
    {
        $media = new Media(['size' => 102400]);

        $this->assertSame(102400, $media->getSize());
    }

    #[Test]
    public function getSizeReturnsNullWhenNotSet(): void
    {
        $media = new Media([]);

        $this->assertNull($media->getSize());
    }
}
