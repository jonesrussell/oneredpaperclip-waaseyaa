<?php

declare(strict_types=1);

namespace OneRedPaperclip\Tests\Unit\Entity;

use OneRedPaperclip\Entity\Follow;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

#[CoversClass(Follow::class)]
final class FollowTest extends TestCase
{
    #[Test]
    public function entityTypeIdIsFollow(): void
    {
        $follow = new Follow([]);

        $this->assertSame('follow', $follow->getEntityTypeId());
    }

    #[Test]
    public function getUserIdReturnsUserId(): void
    {
        $follow = new Follow(['user_id' => 3]);

        $this->assertSame(3, $follow->getUserId());
    }

    #[Test]
    public function getFollowableTypeReturnsType(): void
    {
        $follow = new Follow(['followable_type' => 'challenge']);

        $this->assertSame('challenge', $follow->getFollowableType());
    }

    #[Test]
    public function getFollowableIdReturnsId(): void
    {
        $follow = new Follow(['followable_id' => 7]);

        $this->assertSame(7, $follow->getFollowableId());
    }

    #[Test]
    public function labelReturnsFollowLabel(): void
    {
        $follow = new Follow([]);

        $this->assertSame('Follow #new', $follow->label());
    }
}
