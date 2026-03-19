<?php

declare(strict_types=1);

namespace OneRedPaperclip\Tests\Unit\Schema;

use OneRedPaperclip\Entity\Challenge;
use OneRedPaperclip\Entity\Comment;
use OneRedPaperclip\Entity\Follow;
use OneRedPaperclip\Entity\Item;
use OneRedPaperclip\Entity\Notification;
use OneRedPaperclip\Entity\Offer;
use OneRedPaperclip\Entity\Trade;
use OneRedPaperclip\Enum\ChallengeStatus;
use OneRedPaperclip\Enum\ChallengeVisibility;
use OneRedPaperclip\Enum\ItemRole;
use OneRedPaperclip\Enum\OfferStatus;
use OneRedPaperclip\Enum\TradeStatus;
use OneRedPaperclip\Schema\SchemaInstaller;
use OneRedPaperclip\TradeUpServiceProvider;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use Psr\EventDispatcher\EventDispatcherInterface;
use Waaseyaa\Database\DBALDatabase;
use Waaseyaa\Entity\EntityTypeInterface;
use Waaseyaa\EntityStorage\EntityStorageFactory;

#[CoversClass(SchemaInstaller::class)]
final class StorageIntegrationTest extends TestCase
{
    private DBALDatabase $database;
    private EntityStorageFactory $storageFactory;

    /** @var array<string, EntityTypeInterface> */
    private array $entityTypes = [];

    protected function setUp(): void
    {
        $this->database = DBALDatabase::createSqlite();

        $provider = new TradeUpServiceProvider();
        $provider->register();

        $installer = new SchemaInstaller($this->database, $provider->getEntityTypes());
        $installer->install();

        $dispatcher = new class implements EventDispatcherInterface {
            public function dispatch(object $event): object
            {
                return $event;
            }
        };

        $this->storageFactory = new EntityStorageFactory($this->database, $dispatcher);

        foreach ($provider->getEntityTypes() as $type) {
            $this->entityTypes[$type->id()] = $type;
        }
    }

    #[Test]
    public function challengeRoundTrip(): void
    {
        $storage = $this->storageFactory->getStorage($this->entityTypes['challenge']);

        $challenge = new Challenge([
            'title' => 'Red Paperclip Challenge',
            'slug' => 'red-paperclip',
            'description' => 'Trade up from a paperclip to a house',
            'status' => ChallengeStatus::Published->value,
            'visibility' => ChallengeVisibility::Public->value,
            'user_id' => 1,
            'category_tid' => 3,
        ]);

        $storage->save($challenge);
        $id = $challenge->id();

        $loaded = $storage->load($id);

        $this->assertInstanceOf(Challenge::class, $loaded);
        $this->assertSame('Red Paperclip Challenge', $loaded->getTitle());
        $this->assertSame('red-paperclip', $loaded->getSlug());
        $this->assertSame('Trade up from a paperclip to a house', $loaded->getDescription());
        $this->assertSame(ChallengeStatus::Published, $loaded->getStatus());
        $this->assertSame(ChallengeVisibility::Public, $loaded->getVisibility());
        $this->assertSame(1, $loaded->getUserId());
        $this->assertSame(3, $loaded->getCategoryTid());
    }

    #[Test]
    public function itemRoundTrip(): void
    {
        $storage = $this->storageFactory->getStorage($this->entityTypes['item']);

        $item = new Item([
            'title' => 'Red Paperclip',
            'description' => 'A single red paperclip',
            'role' => ItemRole::Start->value,
            'itemable_type' => 'challenge',
            'itemable_id' => 1,
            'estimated_value' => '0.01',
        ]);

        $storage->save($item);
        $loaded = $storage->load($item->id());

        $this->assertInstanceOf(Item::class, $loaded);
        $this->assertSame('Red Paperclip', $loaded->getTitle());
        $this->assertSame(ItemRole::Start, $loaded->getRole());
        $this->assertSame('challenge', $loaded->getItemableType());
        $this->assertSame(1, $loaded->getItemableId());
        $this->assertSame('0.01', $loaded->getEstimatedValue());
    }

    #[Test]
    public function offerRoundTrip(): void
    {
        $storage = $this->storageFactory->getStorage($this->entityTypes['offer']);

        $offer = new Offer([
            'user_id' => 2,
            'challenge_id' => 1,
            'item_id' => 5,
            'target_item_id' => 3,
            'status' => OfferStatus::Pending->value,
            'message' => 'I have a great pen!',
        ]);

        $storage->save($offer);
        $loaded = $storage->load($offer->id());

        $this->assertInstanceOf(Offer::class, $loaded);
        $this->assertSame(2, $loaded->getUserId());
        $this->assertSame(1, $loaded->getChallengeId());
        $this->assertSame(5, $loaded->getItemId());
        $this->assertSame(3, $loaded->getTargetItemId());
        $this->assertSame(OfferStatus::Pending, $loaded->getStatus());
        $this->assertSame('I have a great pen!', $loaded->getMessage());
    }

    #[Test]
    public function tradeRoundTrip(): void
    {
        $storage = $this->storageFactory->getStorage($this->entityTypes['trade']);

        $trade = new Trade([
            'challenge_id' => 1,
            'offer_id' => 2,
            'position' => 1,
            'status' => TradeStatus::PendingConfirmation->value,
        ]);

        $storage->save($trade);
        $loaded = $storage->load($trade->id());

        $this->assertInstanceOf(Trade::class, $loaded);
        $this->assertSame(1, $loaded->getChallengeId());
        $this->assertSame(2, $loaded->getOfferId());
        $this->assertSame(1, $loaded->getPosition());
        $this->assertSame(TradeStatus::PendingConfirmation, $loaded->getStatus());
        $this->assertNull($loaded->getConfirmedByOwnerAt());
    }

    #[Test]
    public function tradeConfirmationRoundTrip(): void
    {
        $storage = $this->storageFactory->getStorage($this->entityTypes['trade']);

        $trade = new Trade([
            'challenge_id' => 1,
            'offer_id' => 2,
            'position' => 1,
        ]);

        $storage->save($trade);

        $trade->confirmByOwner('2026-03-19 12:00:00');
        $trade->setStatus(TradeStatus::Completed);
        $storage->save($trade);

        $loaded = $storage->load($trade->id());

        $this->assertSame('2026-03-19 12:00:00', $loaded->getConfirmedByOwnerAt());
        $this->assertSame(TradeStatus::Completed, $loaded->getStatus());
    }

    #[Test]
    public function challengeUpdateRoundTrip(): void
    {
        $storage = $this->storageFactory->getStorage($this->entityTypes['challenge']);

        $challenge = new Challenge([
            'title' => 'Original Title',
            'slug' => 'original',
            'status' => ChallengeStatus::Draft->value,
        ]);

        $storage->save($challenge);

        $challenge->setTitle('Updated Title');
        $challenge->setStatus(ChallengeStatus::Published);
        $storage->save($challenge);

        $loaded = $storage->load($challenge->id());

        $this->assertSame('Updated Title', $loaded->getTitle());
        $this->assertSame(ChallengeStatus::Published, $loaded->getStatus());
    }

    #[Test]
    public function commentRoundTrip(): void
    {
        $storage = $this->storageFactory->getStorage($this->entityTypes['comment']);

        $comment = new Comment([
            'body' => 'This is a great challenge!',
            'user_id' => 3,
            'commentable_type' => 'challenge',
            'commentable_id' => 1,
        ]);

        $storage->save($comment);
        $loaded = $storage->load($comment->id());

        $this->assertInstanceOf(Comment::class, $loaded);
        $this->assertSame('This is a great challenge!', $loaded->getBody());
        $this->assertSame(3, $loaded->getUserId());
        $this->assertSame('challenge', $loaded->getCommentableType());
        $this->assertSame(1, $loaded->getCommentableId());
        $this->assertSame(0, $loaded->getParentId());
    }

    #[Test]
    public function followRoundTrip(): void
    {
        $storage = $this->storageFactory->getStorage($this->entityTypes['follow']);

        $follow = new Follow([
            'user_id' => 5,
            'followable_type' => 'challenge',
            'followable_id' => 1,
        ]);

        $storage->save($follow);
        $loaded = $storage->load($follow->id());

        $this->assertInstanceOf(Follow::class, $loaded);
        $this->assertSame(5, $loaded->getUserId());
        $this->assertSame('challenge', $loaded->getFollowableType());
        $this->assertSame(1, $loaded->getFollowableId());
    }

    #[Test]
    public function notificationRoundTrip(): void
    {
        $storage = $this->storageFactory->getStorage($this->entityTypes['notification']);

        $notification = new Notification([
            'user_id' => 1,
            'type' => 'OfferAccepted',
            'data' => json_encode(['challenge_id' => 1, 'offer_id' => 2]),
        ]);

        $storage->save($notification);
        $loaded = $storage->load($notification->id());

        $this->assertInstanceOf(Notification::class, $loaded);
        $this->assertSame(1, $loaded->getUserId());
        $this->assertSame('OfferAccepted', $loaded->getType());
        $this->assertTrue($loaded->isUnread());
    }
}
