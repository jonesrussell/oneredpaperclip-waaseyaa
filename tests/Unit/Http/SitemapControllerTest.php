<?php

declare(strict_types=1);

namespace OneRedPaperclip\Tests\Unit\Http;

use OneRedPaperclip\Action\CreateChallenge;
use OneRedPaperclip\Http\Controller\SitemapController;
use OneRedPaperclip\Schema\SchemaInstaller;
use OneRedPaperclip\TradeUpServiceProvider;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use Psr\EventDispatcher\EventDispatcherInterface;
use Waaseyaa\Database\DBALDatabase;
use Waaseyaa\EntityStorage\EntityStorageFactory;

#[CoversClass(SitemapController::class)]
final class SitemapControllerTest extends TestCase
{
    private SitemapController $controller;
    private EntityStorageFactory $factory;

    /** @var array<string, \Waaseyaa\Entity\EntityTypeInterface> */
    private array $types;

    protected function setUp(): void
    {
        $database = DBALDatabase::createSqlite();
        $provider = new TradeUpServiceProvider();
        $provider->register();
        (new SchemaInstaller($database, $provider->getEntityTypes()))->install();

        $dispatcher = new class implements EventDispatcherInterface {
            public function dispatch(object $event): object { return $event; }
        };
        $this->factory = new EntityStorageFactory($database, $dispatcher);
        $this->types = [];
        foreach ($provider->getEntityTypes() as $type) {
            $this->types[$type->id()] = $type;
        }

        $this->controller = new SitemapController(
            $this->factory->getStorage($this->types['challenge']),
            'https://oneredpaperclip.com',
        );
    }

    #[Test]
    public function returnsXmlContentType(): void
    {
        $result = ($this->controller)();

        $this->assertSame('application/xml', $result['content_type']);
    }

    #[Test]
    public function includesStaticPages(): void
    {
        $result = ($this->controller)();

        $this->assertStringContainsString('https://oneredpaperclip.com/', $result['body']);
        $this->assertStringContainsString('/about', $result['body']);
        $this->assertStringContainsString('/challenges', $result['body']);
    }

    #[Test]
    public function includesChallengeUrls(): void
    {
        $challengeStorage = $this->factory->getStorage($this->types['challenge']);
        $itemStorage = $this->factory->getStorage($this->types['item']);
        $action = new CreateChallenge($challengeStorage, $itemStorage);
        $action->execute(1, [
            'title' => 'Test',
            'slug' => 'test-challenge',
            'start_item' => ['title' => 'Start'],
            'goal_item' => ['title' => 'Goal'],
        ]);

        $result = ($this->controller)();

        $this->assertStringContainsString('/challenges/test-challenge', $result['body']);
    }

    #[Test]
    public function outputIsValidXml(): void
    {
        $result = ($this->controller)();

        $this->assertStringStartsWith('<?xml', $result['body']);
        $this->assertStringContainsString('<urlset', $result['body']);
        $this->assertStringContainsString('</urlset>', $result['body']);
    }
}
