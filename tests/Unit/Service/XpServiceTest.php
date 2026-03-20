<?php

declare(strict_types=1);

namespace OneRedPaperclip\Tests\Unit\Service;

use OneRedPaperclip\Entity\User;
use OneRedPaperclip\Schema\SchemaInstaller;
use OneRedPaperclip\Service\XpService;
use OneRedPaperclip\TradeUpServiceProvider;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use Psr\EventDispatcher\EventDispatcherInterface;
use Waaseyaa\Database\DBALDatabase;
use Waaseyaa\EntityStorage\EntityStorageFactory;
use Waaseyaa\EntityStorage\SqlEntityStorage;

#[CoversClass(XpService::class)]
final class XpServiceTest extends TestCase
{
    private XpService $xpService;
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
        foreach ($provider->getEntityTypes() as $type) {
            $types[$type->id()] = $type;
        }

        $this->userStorage = $factory->getStorage($types['user']);
        $this->xpService = new XpService($this->userStorage);
    }

    #[Test]
    public function awardAddsXp(): void
    {
        $user = new User(['name' => 'Test', 'email' => 'test@test.com', 'password' => 'hash']);
        $this->userStorage->save($user);

        $this->xpService->award($user, XpService::CREATE_CHALLENGE);

        $this->assertSame(50, $user->getXp());
    }

    #[Test]
    public function awardLevelsUp(): void
    {
        $user = new User(['name' => 'Test', 'email' => 'test@test.com', 'password' => 'hash']);
        $this->userStorage->save($user);

        // Level 2 requires 250 * 2^1.5 ≈ 707 XP.
        $this->xpService->award($user, 710);

        $this->assertSame(2, $user->getLevel());
    }

    #[Test]
    public function xpRequiredForLevelMatchesFormula(): void
    {
        $this->assertSame(250, XpService::xpRequiredForLevel(1));
        $this->assertSame(707, XpService::xpRequiredForLevel(2));
        $this->assertSame(1299, XpService::xpRequiredForLevel(3));
    }

    #[Test]
    public function levelForXpCalculatesCorrectly(): void
    {
        $this->assertSame(1, XpService::levelForXp(0));
        $this->assertSame(1, XpService::levelForXp(249));
        $this->assertSame(1, XpService::levelForXp(706));
        $this->assertSame(2, XpService::levelForXp(707));
        $this->assertSame(3, XpService::levelForXp(1299));
    }

    #[Test]
    public function streakMultiplierApplied(): void
    {
        $user = new User(['name' => 'Test', 'email' => 'test@test.com', 'password' => 'hash', 'current_streak' => 5]);
        $this->userStorage->save($user);

        $awarded = $this->xpService->award($user, 100);

        // 100 * (1 + (5-1) * 0.1) = 100 * 1.4 = 140
        $this->assertSame(140, $awarded);
        $this->assertSame(140, $user->getXp());
    }

    #[Test]
    public function noMultiplierForStreakOne(): void
    {
        $user = new User(['name' => 'Test', 'email' => 'test@test.com', 'password' => 'hash', 'current_streak' => 1]);
        $this->userStorage->save($user);

        $awarded = $this->xpService->award($user, 100);

        $this->assertSame(100, $awarded);
    }
}
