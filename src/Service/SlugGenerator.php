<?php

declare(strict_types=1);

namespace OneRedPaperclip\Service;

use Waaseyaa\EntityStorage\SqlEntityStorage;

/**
 * Generates unique URL slugs for challenges and categories.
 */
final class SlugGenerator
{
    public function __construct(
        private readonly SqlEntityStorage $storage,
    ) {}

    /**
     * Generate a unique slug from a title.
     *
     * Converts to lowercase, replaces non-alphanumeric with hyphens,
     * trims, and appends a suffix if the slug already exists.
     */
    public function generate(string $title, ?int $excludeId = null): string
    {
        $base = $this->slugify($title);

        if ($base === '') {
            $base = 'untitled';
        }

        $slug = $base;
        $suffix = 1;

        while ($this->slugExists($slug, $excludeId)) {
            $suffix++;
            $slug = $base . '-' . $suffix;
        }

        return $slug;
    }

    private function slugify(string $text): string
    {
        $text = mb_strtolower($text);
        $text = preg_replace('/[^a-z0-9]+/', '-', $text) ?? $text;
        $text = trim($text, '-');

        return $text;
    }

    private function slugExists(string $slug, ?int $excludeId): bool
    {
        $ids = $this->storage->getQuery()
            ->condition('slug', $slug)
            ->execute();

        if ($ids === []) {
            return false;
        }

        if ($excludeId !== null && \count($ids) === 1 && reset($ids) === $excludeId) {
            return false;
        }

        return true;
    }
}
