<?php

declare(strict_types=1);

namespace OneRedPaperclip\Http\Controller;

use OneRedPaperclip\Entity\Challenge;
use Waaseyaa\EntityStorage\SqlEntityStorage;

/**
 * Generates sitemap.xml with all public challenge URLs.
 */
final class SitemapController
{
    public function __construct(
        private readonly SqlEntityStorage $challengeStorage,
        private readonly string $baseUrl = '',
    ) {}

    /** @return array{content_type: string, body: string} */
    public function __invoke(): array
    {
        $ids = $this->challengeStorage->getQuery()
            ->condition('status', 'active')
            ->condition('visibility', 'public')
            ->execute();

        $urls = [
            $this->url('/', '1.0'),
            $this->url('/about', '0.5'),
            $this->url('/challenges', '0.9'),
        ];

        foreach ($ids as $id) {
            $challenge = $this->challengeStorage->load($id);
            if ($challenge instanceof Challenge && $challenge->getSlug() !== '') {
                $urls[] = $this->url(
                    '/challenges/' . $challenge->getSlug(),
                    '0.8',
                    $challenge->getUpdatedAt(),
                );
            }
        }

        $xml = '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
        $xml .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">' . "\n";
        $xml .= implode("\n", $urls);
        $xml .= "\n</urlset>";

        return [
            'content_type' => 'application/xml',
            'body' => $xml,
        ];
    }

    private function url(string $path, string $priority, ?string $lastmod = null): string
    {
        $loc = htmlspecialchars($this->baseUrl . $path);
        $entry = "  <url>\n    <loc>{$loc}</loc>\n    <priority>{$priority}</priority>";

        if ($lastmod !== null) {
            $date = substr($lastmod, 0, 10);
            $entry .= "\n    <lastmod>{$date}</lastmod>";
        }

        $entry .= "\n  </url>";

        return $entry;
    }
}
