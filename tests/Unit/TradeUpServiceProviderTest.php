<?php

declare(strict_types=1);

namespace OneRedPaperclip\Tests\Unit;

use OneRedPaperclip\Entity\Challenge;
use OneRedPaperclip\Entity\Comment;
use OneRedPaperclip\Entity\Follow;
use OneRedPaperclip\Entity\Item;
use OneRedPaperclip\Entity\Notification;
use OneRedPaperclip\Entity\Offer;
use OneRedPaperclip\Entity\Trade;
use OneRedPaperclip\TradeUpServiceProvider;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

#[CoversClass(TradeUpServiceProvider::class)]
final class TradeUpServiceProviderTest extends TestCase
{
    private TradeUpServiceProvider $provider;

    protected function setUp(): void
    {
        $this->provider = new TradeUpServiceProvider();
        $this->provider->register();
    }

    #[Test]
    public function registersSevenEntityTypes(): void
    {
        $this->assertCount(7, $this->provider->getEntityTypes());
    }

    /**
     * @return array<string, array{string, class-string}>
     */
    public static function entityTypeProvider(): array
    {
        return [
            'challenge' => ['challenge', Challenge::class],
            'item' => ['item', Item::class],
            'offer' => ['offer', Offer::class],
            'trade' => ['trade', Trade::class],
            'comment' => ['comment', Comment::class],
            'follow' => ['follow', Follow::class],
            'notification' => ['notification', Notification::class],
        ];
    }

    #[Test]
    #[DataProvider('entityTypeProvider')]
    public function registersEntityType(string $id, string $class): void
    {
        $types = $this->provider->getEntityTypes();
        $found = null;

        foreach ($types as $type) {
            if ($type->id() === $id) {
                $found = $type;
                break;
            }
        }

        $this->assertNotNull($found, "Entity type '$id' not registered");
        $this->assertSame($class, $found->getClass());
    }

    #[Test]
    public function challengeEntityTypeHasFieldDefinitions(): void
    {
        $types = $this->provider->getEntityTypes();
        $challenge = null;

        foreach ($types as $type) {
            if ($type->id() === 'challenge') {
                $challenge = $type;
                break;
            }
        }

        $this->assertNotNull($challenge);
        $fields = $challenge->getFieldDefinitions();
        $this->assertArrayHasKey('title', $fields);
        $this->assertArrayHasKey('slug', $fields);
        $this->assertArrayHasKey('status', $fields);
        $this->assertArrayHasKey('visibility', $fields);
        $this->assertArrayHasKey('user_id', $fields);
        $this->assertArrayHasKey('category_tid', $fields);
    }
}
