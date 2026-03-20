<?php

declare(strict_types=1);

namespace OneRedPaperclip\Tests\Unit\Http;

use OneRedPaperclip\Http\Controller\PageController;
use OneRedPaperclip\Schema\SchemaInstaller;
use OneRedPaperclip\TradeUpServiceProvider;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use Psr\EventDispatcher\EventDispatcherInterface;
use Waaseyaa\Database\DBALDatabase;
use Waaseyaa\EntityStorage\EntityStorageFactory;
use Waaseyaa\Inertia\Inertia;
use Waaseyaa\Inertia\InertiaResponse;

#[CoversClass(PageController::class)]
final class ControllerTest extends TestCase
{
    private PageController $controller;

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

        $this->controller = new PageController(
            $factory->getStorage($types['challenge']),
            $factory->getStorage($types['trade']),
            $factory->getStorage($types['user']),
        );
    }

    protected function tearDown(): void
    {
        Inertia::reset();
    }

    #[Test]
    public function homeRendersWelcomePage(): void
    {
        $response = $this->controller->home();

        $this->assertInstanceOf(InertiaResponse::class, $response);

        $page = $response->toPageObject();
        $this->assertSame('Welcome', $page['component']);
        $this->assertArrayHasKey('stats', $page['props']);
        $this->assertArrayHasKey('featuredChallenges', $page['props']);
    }

    #[Test]
    public function aboutRendersAboutPage(): void
    {
        $response = $this->controller->about();

        $page = $response->toPageObject();
        $this->assertSame('About', $page['component']);
    }
}
