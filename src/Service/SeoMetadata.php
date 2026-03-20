<?php

declare(strict_types=1);

namespace OneRedPaperclip\Service;

use OneRedPaperclip\Entity\Challenge;

/**
 * Generates SEO metadata for pages.
 */
final class SeoMetadata
{
    private const int MAX_DESCRIPTION_LENGTH = 160;

    /**
     * @return array{title: string, description: string, og_type: string}
     */
    public function forChallenge(Challenge $challenge): array
    {
        $description = $challenge->getStory();

        if (mb_strlen($description) > self::MAX_DESCRIPTION_LENGTH) {
            $description = mb_substr($description, 0, self::MAX_DESCRIPTION_LENGTH - 3) . '...';
        }

        if ($description === '') {
            $description = "Follow {$challenge->getTitle()} — a trade-up challenge on One Red Paperclip.";
        }

        return [
            'title' => $challenge->getTitle() . ' — One Red Paperclip',
            'description' => $description,
            'og_type' => 'article',
        ];
    }

    /**
     * @return array{title: string, description: string, og_type: string}
     */
    public function forPage(string $title, string $description = ''): array
    {
        if ($description === '') {
            $description = 'Trade up from a red paperclip to your dream item. Create challenges, make offers, and trade your way to the top.';
        }

        return [
            'title' => $title . ' — One Red Paperclip',
            'description' => $description,
            'og_type' => 'website',
        ];
    }
}
