<?php

declare(strict_types=1);

namespace OneRedPaperclip\Tests\Unit\Queue;

use OneRedPaperclip\Entity\Challenge;
use OneRedPaperclip\Entity\Offer;
use OneRedPaperclip\Notification\NotificationFactory;
use OneRedPaperclip\Queue\NotificationDispatcher;
use OneRedPaperclip\Schema\SchemaInstaller;
use OneRedPaperclip\TradeUpServiceProvider;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use Psr\EventDispatcher\EventDispatcherInterface;
use Waaseyaa\Database\DBALDatabase;
use Waaseyaa\EntityStorage\EntityStorageFactory;

#[CoversClass(NotificationDispatcher::class)]
final class NotificationDispatcherTest extends TestCase
{
    private NotificationDispatcher $dispatcher;
    private DBALDatabase $database;

    protected function setUp(): void
    {
        $this->database = DBALDatabase::createSqlite();
        $provider = new TradeUpServiceProvider();
        $provider->register();
        (new SchemaInstaller($this->database, $provider->getEntityTypes()))->install();

        $eventDispatcher = new class implements EventDispatcherInterface {
            public function dispatch(object $event): object
            {
                return $event;
            }
        };

        $factory = new EntityStorageFactory($this->database, $eventDispatcher);
        $entityTypes = [];
        foreach ($provider->getEntityTypes() as $type) {
            $entityTypes[$type->id()] = $type;
        }

        $this->dispatcher = new NotificationDispatcher(
            $factory->getStorage($entityTypes['notification']),
        );
    }

    #[Test]
    public function dispatchSavesNotification(): void
    {
        $factory = new NotificationFactory();
        $challenge = new Challenge(['id' => 1, 'title' => 'Test', 'user_id' => 10]);
        $offer = new Offer(['id' => 5, 'from_user_id' => 20]);

        $notification = $factory->offerReceived(10, $offer, $challenge);
        $this->dispatcher->dispatch($notification);

        $this->assertNotNull($notification->id());
        $this->assertCount(1, $this->dispatcher->getDispatched());
    }

    #[Test]
    public function dispatchManySavesAllNotifications(): void
    {
        $factory = new NotificationFactory();
        $challenge = new Challenge(['id' => 1, 'title' => 'Test', 'user_id' => 10]);
        $offer = new Offer(['id' => 5, 'from_user_id' => 20]);

        $notifications = [
            $factory->offerReceived(10, $offer, $challenge),
            $factory->offerReceived(11, $offer, $challenge),
            $factory->offerReceived(12, $offer, $challenge),
        ];

        $this->dispatcher->dispatchMany($notifications);

        $this->assertCount(3, $this->dispatcher->getDispatched());

        // Verify all saved to DB.
        $rows = $this->database->select('notification')
            ->fields('notification')
            ->execute();
        $this->assertCount(3, iterator_to_array($rows));
    }

    #[Test]
    public function dispatchedNotificationsArePersisted(): void
    {
        $factory = new NotificationFactory();
        $challenge = new Challenge(['id' => 1, 'title' => 'Test']);

        $notification = $factory->challengeCompleted(10, $challenge);
        $this->dispatcher->dispatch($notification);

        $rows = $this->database->select('notification')
            ->fields('notification')
            ->execute();
        $row = (array) iterator_to_array($rows)[0];

        $this->assertSame('challenge_completed', $row['type']);
    }
}
