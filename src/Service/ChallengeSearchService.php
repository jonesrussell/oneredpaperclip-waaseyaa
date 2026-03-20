<?php

declare(strict_types=1);

namespace OneRedPaperclip\Service;

use OneRedPaperclip\Entity\Challenge;
use Waaseyaa\EntityStorage\SqlEntityStorage;

/**
 * Search service for challenges.
 *
 * Uses entity query conditions for filtering. Can be upgraded to
 * use waaseyaa/search with full-text indexing when needed.
 */
final class ChallengeSearchService
{
    public function __construct(
        private readonly SqlEntityStorage $challengeStorage,
    ) {}

    /**
     * Search public active challenges by title match.
     *
     * @return list<Challenge>
     */
    public function search(string $query, int $limit = 20): array
    {
        if ($query === '') {
            return [];
        }

        $ids = $this->challengeStorage->getQuery()
            ->condition('status', 'active')
            ->condition('visibility', 'public')
            ->condition('title', $query, 'CONTAINS')
            ->execute();

        $results = [];
        $count = 0;

        foreach ($ids as $id) {
            if ($count >= $limit) {
                break;
            }

            $challenge = $this->challengeStorage->load($id);
            if ($challenge instanceof Challenge) {
                $results[] = $challenge;
                $count++;
            }
        }

        return $results;
    }

    /**
     * Filter challenges by category.
     *
     * @return list<Challenge>
     */
    public function byCategory(int $categoryId, int $limit = 20): array
    {
        $ids = $this->challengeStorage->getQuery()
            ->condition('status', 'active')
            ->condition('visibility', 'public')
            ->condition('category_id', $categoryId)
            ->execute();

        $results = [];
        $count = 0;

        foreach ($ids as $id) {
            if ($count >= $limit) {
                break;
            }

            $challenge = $this->challengeStorage->load($id);
            if ($challenge instanceof Challenge) {
                $results[] = $challenge;
                $count++;
            }
        }

        return $results;
    }
}
