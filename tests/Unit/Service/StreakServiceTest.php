<?php

declare(strict_types=1);

namespace OneRedPaperclip\Tests\Unit\Service;

use OneRedPaperclip\Entity\User;
use OneRedPaperclip\Schema\SchemaInstaller;
use OneRedPaperclip\Service\StreakService;
use OneRedPaperclip\TradeUpServiceProvider;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use Psr\EventDispatcher\EventDispatcherInterface;
use Waaseyaa\Database\DBALDatabase;
use Waaseyaa\EntityStorage\EntityStorageFactory;
use Waaseyaa\EntityStorage\SqlEntityStorage;

#[CoversClass(StreakService::class)]
final class StreakServiceTest extends TestCase
{
    private StreakService $streakService;
    private SqlEntityStorage $userStorage;

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

        $this->userStorage = $factory->getStorage($types['user']);
        $this->streakService = new StreakService($this->userStorage);
    }

    #[Test]
    public function firstActivityStartsStreak(): void
    {
        $user = new User(['name' => 'Test', 'email' => 'a@b.com', 'password' => 'h']);
        $this->userStorage->save($user);

        $this->streakService->recordActivity($user, '2026-03-19T10:00:00Z');

        $this->assertSame(1, $user->getCurrentStreak());
        $this->assertSame(1, $user->getLongestStreak());
    }

    #[Test]
    public function consecutiveDayIncrementsStreak(): void
    {
        $user = new User(['name' => 'Test', 'email' => 'a@b.com', 'password' => 'h']);
        $this->userStorage->save($user);

        $this->streakService->recordActivity($user, '2026-03-19T10:00:00Z');
        $this->streakService->recordActivity($user, '2026-03-20T10:00:00Z');

        $this->assertSame(2, $user->getCurrentStreak());
    }

    #[Test]
    public function sameDayIsNoOp(): void
    {
        $user = new User(['name' => 'Test', 'email' => 'a@b.com', 'password' => 'h']);
        $this->userStorage->save($user);

        $this->streakService->recordActivity($user, '2026-03-19T10:00:00Z');
        $this->streakService->recordActivity($user, '2026-03-19T23:00:00Z');

        $this->assertSame(1, $user->getCurrentStreak());
    }

    #[Test]
    public function gapResetsStreak(): void
    {
        $user = new User(['name' => 'Test', 'email' => 'a@b.com', 'password' => 'h']);
        $this->userStorage->save($user);

        $this->streakService->recordActivity($user, '2026-03-19T10:00:00Z');
        $this->streakService->recordActivity($user, '2026-03-20T10:00:00Z');
        $this->streakService->recordActivity($user, '2026-03-22T10:00:00Z'); // skipped 21

        $this->assertSame(1, $user->getCurrentStreak());
        $this->assertSame(2, $user->getLongestStreak());
    }

    #[Test]
    public function longestStreakPreserved(): void
    {
        $user = new User(['name' => 'Test', 'email' => 'a@b.com', 'password' => 'h']);
        $this->userStorage->save($user);

        $this->streakService->recordActivity($user, '2026-03-19T10:00:00Z');
        $this->streakService->recordActivity($user, '2026-03-20T10:00:00Z');
        $this->streakService->recordActivity($user, '2026-03-21T10:00:00Z');

        $this->assertSame(3, $user->getCurrentStreak());
        $this->assertSame(3, $user->getLongestStreak());

        $this->streakService->recordActivity($user, '2026-03-25T10:00:00Z'); // gap

        $this->assertSame(1, $user->getCurrentStreak());
        $this->assertSame(3, $user->getLongestStreak());
    }
}
