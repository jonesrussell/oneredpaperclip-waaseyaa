<?php

declare(strict_types=1);

namespace OneRedPaperclip\Media;

/**
 * In-memory storage adapter for testing.
 */
final class InMemoryStorageAdapter implements StorageAdapterInterface
{
    /** @var array<string, string> path => content */
    private array $files = [];

    public function put(string $path, string $sourcePath): void
    {
        $this->files[$path] = file_exists($sourcePath) ? file_get_contents($sourcePath) : '';
    }

    public function delete(string $path): void
    {
        unset($this->files[$path]);
    }

    public function url(string $path): string
    {
        return '/storage/' . $path;
    }

    public function exists(string $path): bool
    {
        return isset($this->files[$path]);
    }

    public function disk(): string
    {
        return 'memory';
    }

    /** @return array<string, string> */
    public function getFiles(): array
    {
        return $this->files;
    }
}
