<?php

declare(strict_types=1);

namespace OneRedPaperclip\Tests\Unit\Action;

use OneRedPaperclip\Action\CreateChallenge;
use OneRedPaperclip\Entity\Challenge;
use OneRedPaperclip\Enum\ChallengeStatus;
use OneRedPaperclip\Enum\ChallengeVisibility;
use OneRedPaperclip\Enum\ItemRole;
use OneRedPaperclip\Schema\SchemaInstaller;
use OneRedPaperclip\TradeUpServiceProvider;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use Psr\EventDispatcher\EventDispatcherInterface;
use Waaseyaa\Database\DBALDatabase;
use Waaseyaa\EntityStorage\EntityStorageFactory;

#[CoversClass(CreateChallenge::class)]
final class CreateChallengeTest extends TestCase
{
    private EntityStorageFactory $storageFactory;

    /** @var array<string, \Waaseyaa\Entity\EntityTypeInterface> */
    private array $entityTypes = [];

    protected function setUp(): void
    {
        $database = DBALDatabase::createSqlite();
        $provider = new TradeUpServiceProvider();
        $provider->register();

        (new SchemaInstaller($database, $provider->getEntityTypes()))->install();

        $dispatcher = new class implements EventDispatcherInterface {
            public function dispatch(object $event): object
            {
                return $event;
            }
        };

        $this->storageFactory = new EntityStorageFactory($database, $dispatcher);

        foreach ($provider->getEntityTypes() as $type) {
            $this->entityTypes[$type->id()] = $type;
        }
    }

    #[Test]
    public function createsChallengeWithStartAndGoalItems(): void
    {
        $action = new CreateChallenge(
            $this->storageFactory->getStorage($this->entityTypes['challenge']),
            $this->storageFactory->getStorage($this->entityTypes['item']),
        );

        $challenge = $action->execute(1, [
            'title' => 'Red Paperclip Challenge',
            'slug' => 'red-paperclip',
            'story' => 'Trade up from a paperclip to a house',
            'category_id' => 3,
            'start_item' => ['title' => 'Red Paperclip', 'description' => 'A single red paperclip'],
            'goal_item' => ['title' => 'House', 'description' => 'A real house'],
        ]);

        $this->assertInstanceOf(Challenge::class, $challenge);
        $this->assertNotNull($challenge->id());
        $this->assertSame('Red Paperclip Challenge', $challenge->getTitle());
        $this->assertSame('red-paperclip', $challenge->getSlug());
        $this->assertSame(ChallengeStatus::Active, $challenge->getStatus());
        $this->assertSame(ChallengeVisibility::Public, $challenge->getVisibility());
        $this->assertSame(1, $challenge->getUserId());
        $this->assertSame(3, $challenge->getCategoryId());
    }

    #[Test]
    public function linksCurrentAndGoalItems(): void
    {
        $action = new CreateChallenge(
            $this->storageFactory->getStorage($this->entityTypes['challenge']),
            $this->storageFactory->getStorage($this->entityTypes['item']),
        );

        $challenge = $action->execute(1, [
            'title' => 'Test',
            'slug' => 'test',
            'start_item' => ['title' => 'Start'],
            'goal_item' => ['title' => 'Goal'],
        ]);

        $this->assertNotNull($challenge->getCurrentItemId());
        $this->assertNotNull($challenge->getGoalItemId());
        $this->assertNotSame($challenge->getCurrentItemId(), $challenge->getGoalItemId());
    }

    #[Test]
    public function createsItemsWithCorrectRoles(): void
    {
        $itemStorage = $this->storageFactory->getStorage($this->entityTypes['item']);
        $action = new CreateChallenge(
            $this->storageFactory->getStorage($this->entityTypes['challenge']),
            $itemStorage,
        );

        $challenge = $action->execute(1, [
            'title' => 'Test',
            'slug' => 'test-roles',
            'start_item' => ['title' => 'Start Item'],
            'goal_item' => ['title' => 'Goal Item'],
        ]);

        $startItem = $itemStorage->load($challenge->getCurrentItemId());
        $goalItem = $itemStorage->load($challenge->getGoalItemId());

        $this->assertSame(ItemRole::Start, $startItem->getRole());
        $this->assertSame(ItemRole::Goal, $goalItem->getRole());
        $this->assertSame('Start Item', $startItem->getTitle());
        $this->assertSame('Goal Item', $goalItem->getTitle());
    }

    #[Test]
    public function defaultsToActiveAndPublic(): void
    {
        $action = new CreateChallenge(
            $this->storageFactory->getStorage($this->entityTypes['challenge']),
            $this->storageFactory->getStorage($this->entityTypes['item']),
        );

        $challenge = $action->execute(1, [
            'title' => 'Test',
            'slug' => 'test-defaults',
            'start_item' => ['title' => 'Start'],
            'goal_item' => ['title' => 'Goal'],
        ]);

        $this->assertSame(ChallengeStatus::Active, $challenge->getStatus());
        $this->assertSame(ChallengeVisibility::Public, $challenge->getVisibility());
    }
}
