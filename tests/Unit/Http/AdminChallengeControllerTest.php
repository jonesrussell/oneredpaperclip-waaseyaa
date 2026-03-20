<?php

declare(strict_types=1);

namespace OneRedPaperclip\Tests\Unit\Http;

use OneRedPaperclip\Action\CreateChallenge;
use OneRedPaperclip\Enum\ChallengeStatus;
use OneRedPaperclip\Http\Controller\Admin\AdminChallengeController;
use OneRedPaperclip\Schema\SchemaInstaller;
use OneRedPaperclip\TradeUpServiceProvider;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use Psr\EventDispatcher\EventDispatcherInterface;
use Waaseyaa\Database\DBALDatabase;
use Waaseyaa\EntityStorage\EntityStorageFactory;
use Waaseyaa\EntityStorage\SqlEntityStorage;
use Waaseyaa\Inertia\Inertia;

#[CoversClass(AdminChallengeController::class)]
final class AdminChallengeControllerTest extends TestCase
{
    private AdminChallengeController $controller;
    private SqlEntityStorage $challengeStorage;
    private SqlEntityStorage $itemStorage;

    protected function setUp(): void
    {
        Inertia::reset();
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
        $this->controller = new AdminChallengeController($this->challengeStorage);
    }

    protected function tearDown(): void
    {
        Inertia::reset();
    }

    #[Test]
    public function indexRendersAdminPage(): void
    {
        $response = $this->controller->index();
        $page = $response->toPageObject();

        $this->assertSame('dashboard/admin/challenges/Index', $page['component']);
    }

    #[Test]
    public function unpublishSetsDraft(): void
    {
        $action = new CreateChallenge($this->challengeStorage, $this->itemStorage);
        $challenge = $action->execute(1, [
            'title' => 'Test',
            'slug' => 'test',
            'start_item' => ['title' => 'S'],
            'goal_item' => ['title' => 'G'],
        ]);

        $this->controller->unpublish((int) $challenge->id());

        $reloaded = $this->challengeStorage->load($challenge->id());
        $this->assertSame(ChallengeStatus::Draft, $reloaded->getStatus());
    }

    #[Test]
    public function destroySoftDeletes(): void
    {
        $action = new CreateChallenge($this->challengeStorage, $this->itemStorage);
        $challenge = $action->execute(1, [
            'title' => 'Test',
            'slug' => 'test-del',
            'start_item' => ['title' => 'S'],
            'goal_item' => ['title' => 'G'],
        ]);

        $this->controller->destroy((int) $challenge->id());

        $reloaded = $this->challengeStorage->load($challenge->id());
        $this->assertNotNull($reloaded->getDeletedAt());
    }

    #[Test]
    public function restoreClearsDeletedAt(): void
    {
        $action = new CreateChallenge($this->challengeStorage, $this->itemStorage);
        $challenge = $action->execute(1, [
            'title' => 'Test',
            'slug' => 'test-restore',
            'start_item' => ['title' => 'S'],
            'goal_item' => ['title' => 'G'],
        ]);

        $this->controller->destroy((int) $challenge->id());
        $this->controller->restore((int) $challenge->id());

        $reloaded = $this->challengeStorage->load($challenge->id());
        $this->assertNull($reloaded->getDeletedAt());
    }
}
