<?php

declare(strict_types=1);

namespace OneRedPaperclip\Media;

interface StorageAdapterInterface
{
    /**
     * Store a file at the given path.
     *
     * @param string $path Storage path (relative)
     * @param string $sourcePath Local file path to read from
     */
    public function put(string $path, string $sourcePath): void;

    /**
     * Delete a file at the given path.
     */
    public function delete(string $path): void;

    /**
     * Get a public URL for the file.
     */
    public function url(string $path): string;

    /**
     * Check if a file exists.
     */
    public function exists(string $path): bool;

    /**
     * Get the disk name for this adapter.
     */
    public function disk(): string;
}
