<?php

declare(strict_types=1);

namespace OneRedPaperclip\Media;

final class LocalStorageAdapter implements StorageAdapterInterface
{
    public function __construct(
        private readonly string $basePath,
        private readonly string $baseUrl = '/storage',
    ) {}

    public function put(string $path, string $sourcePath): void
    {
        $fullPath = $this->basePath . '/' . $path;
        $dir = \dirname($fullPath);

        if (!is_dir($dir)) {
            mkdir($dir, 0755, true);
        }

        copy($sourcePath, $fullPath);
    }

    public function delete(string $path): void
    {
        $fullPath = $this->basePath . '/' . $path;

        if (file_exists($fullPath)) {
            unlink($fullPath);
        }
    }

    public function url(string $path): string
    {
        return $this->baseUrl . '/' . $path;
    }

    public function exists(string $path): bool
    {
        return file_exists($this->basePath . '/' . $path);
    }

    public function disk(): string
    {
        return 'local';
    }
}
