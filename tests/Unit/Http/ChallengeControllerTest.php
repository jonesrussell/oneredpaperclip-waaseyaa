<?php

declare(strict_types=1);

namespace OneRedPaperclip\Tests\Unit\Http;

use OneRedPaperclip\Action\CreateChallenge;
use OneRedPaperclip\Auth\AuthService;
use OneRedPaperclip\Http\Controller\ChallengeController;
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
use Waaseyaa\Inertia\InertiaResponse;

#[CoversClass(ChallengeController::class)]
final class ChallengeControllerTest extends TestCase
{
    private ChallengeController $controller;
    private SqlEntityStorage $challengeStorage;
    private SqlEntityStorage $itemStorage;
    private AuthService $auth;

    protected function setUp(): void
    {
        $_SESSION = [];
        Inertia::reset();

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

        $factory = new EntityStorageFactory($database, $dispatcher);
        $types = [];
        foreach ($provider->getEntityTypes() as $type) {
            $types[$type->id()] = $type;
        }

        $this->challengeStorage = $factory->getStorage($types['challenge']);
        $this->itemStorage = $factory->getStorage($types['item']);
        $this->auth = new AuthService($factory->getStorage($types['user']));

        $this->controller = new ChallengeController(
            $this->challengeStorage,
            $this->itemStorage,
            $factory->getStorage($types['category']),
            $factory->getStorage($types['user']),
            $this->auth,
        );
    }

    protected function tearDown(): void
    {
        $_SESSION = [];
        Inertia::reset();
    }

    #[Test]
    public function indexRendersChallengesPage(): void
    {
        $response = $this->controller->index();

        $this->assertInstanceOf(InertiaResponse::class, $response);
        $page = $response->toPageObject();
        $this->assertSame('challenges/Index', $page['component']);
        $this->assertArrayHasKey('challenges', $page['props']);
        $this->assertArrayHasKey('categories', $page['props']);
    }

    #[Test]
    public function showRendersChallengeBySlug(): void
    {
        $user = $this->auth->register(['name' => 'Alice', 'email' => 'a@b.com', 'password' => 'pass']);
        $action = new CreateChallenge($this->challengeStorage, $this->itemStorage);
        $action->execute((int) $user->id(), [
            'title' => 'Test',
            'slug' => 'test-challenge',
            'start_item' => ['title' => 'Start'],
            'goal_item' => ['title' => 'Goal'],
        ]);

        $response = $this->controller->show('test-challenge');

        $page = $response->toPageObject();
        $this->assertSame('challenges/Show', $page['component']);
        $this->assertSame('Test', $page['props']['challenge']['title']);
    }

    #[Test]
    public function showReturnsNotFoundForMissingSlug(): void
    {
        $response = $this->controller->show('nonexistent');

        $page = $response->toPageObject();
        $this->assertSame('errors/NotFound', $page['component']);
    }

    #[Test]
    public function storeCreatesChallenge(): void
    {
        $user = $this->auth->register(['name' => 'Alice', 'email' => 'a@b.com', 'password' => 'pass']);
        $this->auth->login($user);

        $response = $this->controller->store([
            'title' => 'My Challenge',
            'slug' => 'my-challenge',
            'start_item' => ['title' => 'Paperclip'],
            'goal_item' => ['title' => 'House'],
        ]);

        $this->assertInstanceOf(InertiaResponse::class, $response);
        $page = $response->toPageObject();
        $this->assertSame('challenges/Show', $page['component']);
    }

    #[Test]
    public function storeReturnsErrorsForInvalidData(): void
    {
        $user = $this->auth->register(['name' => 'Alice', 'email' => 'a@b.com', 'password' => 'pass']);
        $this->auth->login($user);

        $response = $this->controller->store([]);

        $this->assertIsArray($response);
        $this->assertArrayHasKey('errors', $response);
    }

    #[Test]
    public function editDeniesNonOwner(): void
    {
        $owner = $this->auth->register(['name' => 'Owner', 'email' => 'owner@b.com', 'password' => 'pass']);
        $other = $this->auth->register(['name' => 'Other', 'email' => 'other@b.com', 'password' => 'pass']);

        $action = new CreateChallenge($this->challengeStorage, $this->itemStorage);
        $action->execute((int) $owner->id(), [
            'title' => 'Test',
            'slug' => 'test-edit',
            'start_item' => ['title' => 'Start'],
            'goal_item' => ['title' => 'Goal'],
        ]);

        $this->auth->login($other);
        $response = $this->controller->edit('test-edit');

        $page = $response->toPageObject();
        $this->assertSame('errors/Forbidden', $page['component']);
    }
}
