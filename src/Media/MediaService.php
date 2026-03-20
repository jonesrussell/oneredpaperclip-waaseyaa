<?php

declare(strict_types=1);

namespace OneRedPaperclip\Media;

use OneRedPaperclip\Entity\Media;
use Waaseyaa\EntityStorage\SqlEntityStorage;

/**
 * Handles media file uploads and retrieval.
 *
 * Stores file metadata in the Media entity and delegates physical
 * file storage to a configurable disk (local filesystem or S3/MinIO).
 */
final class MediaService
{
    public function __construct(
        private readonly SqlEntityStorage $mediaStorage,
        private readonly StorageAdapterInterface $storageAdapter,
    ) {}

    /**
     * Store an uploaded file and create a Media entity.
     *
     * @param array{
     *     tmp_path: string,
     *     file_name: string,
     *     size: int,
     *     content_type: string,
     * } $upload
     */
    public function store(string $modelType, int $modelId, array $upload, string $collection = 'default'): Media
    {
        $this->validateUpload($upload);

        $storagePath = $this->generatePath($modelType, $modelId, $upload['file_name']);
        $this->storageAdapter->put($storagePath, $upload['tmp_path']);

        $media = new Media([
            'model_type' => $modelType,
            'model_id' => $modelId,
            'collection_name' => $collection,
            'file_name' => $upload['file_name'],
            'disk' => $this->storageAdapter->disk(),
            'path' => $storagePath,
            'size' => $upload['size'],
        ]);

        $this->mediaStorage->save($media);

        return $media;
    }

    public function delete(Media $media): void
    {
        $this->storageAdapter->delete($media->getPath());
        $this->mediaStorage->delete([$media]);
    }

    public function url(Media $media): string
    {
        return $this->storageAdapter->url($media->getPath());
    }

    /**
     * @param array{tmp_path: string, file_name: string, size: int, content_type: string} $upload
     */
    private function validateUpload(array $upload): void
    {
        $maxSize = 5 * 1024 * 1024; // 5MB
        if ($upload['size'] > $maxSize) {
            throw new \InvalidArgumentException('File size exceeds maximum of 5MB.');
        }

        $allowedTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
        if (!\in_array($upload['content_type'], $allowedTypes, true)) {
            throw new \InvalidArgumentException('File type not allowed. Accepted: JPEG, PNG, GIF, WebP.');
        }
    }

    private function generatePath(string $modelType, int $modelId, string $fileName): string
    {
        $ext = pathinfo($fileName, \PATHINFO_EXTENSION);
        $hash = substr(md5($fileName . microtime()), 0, 8);

        return "uploads/{$modelType}/{$modelId}/{$hash}.{$ext}";
    }
}
