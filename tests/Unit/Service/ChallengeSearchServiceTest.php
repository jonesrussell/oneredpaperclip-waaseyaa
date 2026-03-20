<?php

declare(strict_types=1);

namespace OneRedPaperclip\Tests\Unit\Service;

use OneRedPaperclip\Action\CreateChallenge;
use OneRedPaperclip\Schema\SchemaInstaller;
use OneRedPaperclip\Service\ChallengeSearchService;
use OneRedPaperclip\TradeUpServiceProvider;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use Psr\EventDispatcher\EventDispatcherInterface;
use Waaseyaa\Database\DBALDatabase;
use Waaseyaa\EntityStorage\EntityStorageFactory;
use Waaseyaa\EntityStorage\SqlEntityStorage;

#[CoversClass(ChallengeSearchService::class)]
final class ChallengeSearchServiceTest extends TestCase
{
    private ChallengeSearchService $search;
    private SqlEntityStorage $challengeStorage;
    private SqlEntityStorage $itemStorage;

    protected function setUp(): void
    {
        $database = DBALDatabase::createSqlite();
        $provider = new TradeUpServiceProvider();
        $provider->register();
        (new SchemaInstaller($database, $provider->getEntityTypes()))->install();

        $dispatcher = new class implements EventDispatcherInterface {
            public function dispatch(object $event): object { return $event; }
        };
        $factory = new EntityStorageFactory($database, $dispatcher);
        $types = [];
        foreach ($provider->getEntityTypes() as $type) { $types[$type->id()] = $type; }

        $this->challengeStorage = $factory->getStorage($types['challenge']);
        $this->itemStorage = $factory->getStorage($types['item']);
        $this->search = new ChallengeSearchService($this->challengeStorage);
    }

    #[Test]
    public function searchFindsMatchingChallenges(): void
    {
        $action = new CreateChallenge($this->challengeStorage, $this->itemStorage);
        $action->execute(1, ['title' => 'Red Paperclip Challenge', 'slug' => 'red', 'start_item' => ['title' => 'S'], 'goal_item' => ['title' => 'G']]);
        $action->execute(1, ['title' => 'Blue Pen Challenge', 'slug' => 'blue', 'start_item' => ['title' => 'S'], 'goal_item' => ['title' => 'G']]);

        $results = $this->search->search('Paperclip');

        $this->assertCount(1, $results);
        $this->assertSame('Red Paperclip Challenge', $results[0]->getTitle());
    }

    #[Test]
    public function searchReturnsEmptyForNoMatch(): void
    {
        $this->assertSame([], $this->search->search('nonexistent'));
    }

    #[Test]
    public function searchReturnsEmptyForEmptyQuery(): void
    {
        $this->assertSame([], $this->search->search(''));
    }

    #[Test]
    public function searchRespectsLimit(): void
    {
        $action = new CreateChallenge($this->challengeStorage, $this->itemStorage);
        for ($i = 1; $i <= 5; $i++) {
            $action->execute(1, ['title' => "Challenge {$i}", 'slug' => "c-{$i}", 'start_item' => ['title' => 'S'], 'goal_item' => ['title' => 'G']]);
        }

        $results = $this->search->search('Challenge', 2);

        $this->assertCount(2, $results);
    }

    #[Test]
    public function byCategoryFiltersByCategory(): void
    {
        $action = new CreateChallenge($this->challengeStorage, $this->itemStorage);
        $action->execute(1, ['title' => 'Cat A', 'slug' => 'a', 'category_id' => 1, 'start_item' => ['title' => 'S'], 'goal_item' => ['title' => 'G']]);
        $action->execute(1, ['title' => 'Cat B', 'slug' => 'b', 'category_id' => 2, 'start_item' => ['title' => 'S'], 'goal_item' => ['title' => 'G']]);

        $results = $this->search->byCategory(1);

        $this->assertCount(1, $results);
        $this->assertSame('Cat A', $results[0]->getTitle());
    }
}
