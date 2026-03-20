<?php

declare(strict_types=1);

namespace OneRedPaperclip\Tests\Unit\Service;

use OneRedPaperclip\Entity\Challenge;
use OneRedPaperclip\Schema\SchemaInstaller;
use OneRedPaperclip\Service\SlugGenerator;
use OneRedPaperclip\TradeUpServiceProvider;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use Psr\EventDispatcher\EventDispatcherInterface;
use Waaseyaa\Database\DBALDatabase;
use Waaseyaa\EntityStorage\EntityStorageFactory;
use Waaseyaa\EntityStorage\SqlEntityStorage;

#[CoversClass(SlugGenerator::class)]
final class SlugGeneratorTest extends TestCase
{
    private SlugGenerator $generator;
    private SqlEntityStorage $challengeStorage;

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
        $this->generator = new SlugGenerator($this->challengeStorage);
    }

    #[Test]
    public function generatesSlugFromTitle(): void
    {
        $this->assertSame('my-challenge', $this->generator->generate('My Challenge'));
    }

    #[Test]
    public function convertsToLowercase(): void
    {
        $this->assertSame('hello-world', $this->generator->generate('Hello World'));
    }

    #[Test]
    public function replacesSpecialCharacters(): void
    {
        $this->assertSame('trade-up-2026', $this->generator->generate('Trade Up! (2026)'));
    }

    #[Test]
    public function appendsSuffixForDuplicate(): void
    {
        $challenge = new Challenge(['title' => 'Test', 'slug' => 'my-challenge', 'status' => 'active']);
        $this->challengeStorage->save($challenge);

        $this->assertSame('my-challenge-2', $this->generator->generate('My Challenge'));
    }

    #[Test]
    public function allowsSameSlugWhenExcludingOwnId(): void
    {
        $challenge = new Challenge(['title' => 'Test', 'slug' => 'my-challenge', 'status' => 'active']);
        $this->challengeStorage->save($challenge);

        $this->assertSame('my-challenge', $this->generator->generate('My Challenge', (int) $challenge->id()));
    }

    #[Test]
    public function handlesEmptyTitle(): void
    {
        $this->assertSame('untitled', $this->generator->generate(''));
    }
}
