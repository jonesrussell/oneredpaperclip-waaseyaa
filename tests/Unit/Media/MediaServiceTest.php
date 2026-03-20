<?php

declare(strict_types=1);

namespace OneRedPaperclip\Tests\Unit\Media;

use OneRedPaperclip\Entity\Media;
use OneRedPaperclip\Media\InMemoryStorageAdapter;
use OneRedPaperclip\Media\MediaService;
use OneRedPaperclip\Schema\SchemaInstaller;
use OneRedPaperclip\TradeUpServiceProvider;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use Psr\EventDispatcher\EventDispatcherInterface;
use Waaseyaa\Database\DBALDatabase;
use Waaseyaa\EntityStorage\EntityStorageFactory;

#[CoversClass(MediaService::class)]
final class MediaServiceTest extends TestCase
{
    private MediaService $service;
    private InMemoryStorageAdapter $storage;

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

        $factory = new EntityStorageFactory($database, $dispatcher);
        $entityTypes = [];
        foreach ($provider->getEntityTypes() as $type) {
            $entityTypes[$type->id()] = $type;
        }

        $this->storage = new InMemoryStorageAdapter();
        $this->service = new MediaService(
            $factory->getStorage($entityTypes['media']),
            $this->storage,
        );
    }

    #[Test]
    public function storeCreatesMediaEntity(): void
    {
        $tmpFile = tempnam(sys_get_temp_dir(), 'test');
        file_put_contents($tmpFile, 'fake image data');

        $media = $this->service->store('item', 1, [
            'tmp_path' => $tmpFile,
            'file_name' => 'photo.jpg',
            'size' => 1024,
            'content_type' => 'image/jpeg',
        ]);

        $this->assertInstanceOf(Media::class, $media);
        $this->assertNotNull($media->id());
        $this->assertSame('item', $media->getModelType());
        $this->assertSame(1, $media->getModelId());
        $this->assertSame('photo.jpg', $media->getFileName());
        $this->assertSame('memory', $media->getDisk());
        $this->assertSame(1024, $media->getSize());

        unlink($tmpFile);
    }

    #[Test]
    public function storeWritesFileToAdapter(): void
    {
        $tmpFile = tempnam(sys_get_temp_dir(), 'test');
        file_put_contents($tmpFile, 'fake image data');

        $media = $this->service->store('item', 1, [
            'tmp_path' => $tmpFile,
            'file_name' => 'photo.jpg',
            'size' => 1024,
            'content_type' => 'image/jpeg',
        ]);

        $this->assertTrue($this->storage->exists($media->getPath()));

        unlink($tmpFile);
    }

    #[Test]
    public function urlReturnsStorageUrl(): void
    {
        $tmpFile = tempnam(sys_get_temp_dir(), 'test');
        file_put_contents($tmpFile, 'data');

        $media = $this->service->store('item', 1, [
            'tmp_path' => $tmpFile,
            'file_name' => 'photo.jpg',
            'size' => 100,
            'content_type' => 'image/jpeg',
        ]);

        $url = $this->service->url($media);
        $this->assertStringStartsWith('/storage/', $url);

        unlink($tmpFile);
    }

    #[Test]
    public function rejectsOversizedFile(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('File size exceeds');

        $this->service->store('item', 1, [
            'tmp_path' => '/tmp/fake',
            'file_name' => 'huge.jpg',
            'size' => 10 * 1024 * 1024,
            'content_type' => 'image/jpeg',
        ]);
    }

    #[Test]
    public function rejectsDisallowedContentType(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('File type not allowed');

        $this->service->store('item', 1, [
            'tmp_path' => '/tmp/fake',
            'file_name' => 'script.php',
            'size' => 100,
            'content_type' => 'application/x-php',
        ]);
    }

    #[Test]
    public function deleteRemovesFileAndEntity(): void
    {
        $tmpFile = tempnam(sys_get_temp_dir(), 'test');
        file_put_contents($tmpFile, 'data');

        $media = $this->service->store('item', 1, [
            'tmp_path' => $tmpFile,
            'file_name' => 'photo.jpg',
            'size' => 100,
            'content_type' => 'image/jpeg',
        ]);

        $path = $media->getPath();
        $this->assertTrue($this->storage->exists($path));

        $this->service->delete($media);
        $this->assertFalse($this->storage->exists($path));

        unlink($tmpFile);
    }
}
