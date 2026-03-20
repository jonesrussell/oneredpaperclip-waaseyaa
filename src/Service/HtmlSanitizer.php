<?php

declare(strict_types=1);

namespace OneRedPaperclip\Service;

/**
 * Sanitizes rich text HTML content.
 *
 * Strips dangerous tags and attributes while preserving safe
 * formatting tags used by the rich text editor.
 */
final class HtmlSanitizer
{
    /** @var list<string> */
    private const array ALLOWED_TAGS = [
        'p', 'br', 'strong', 'em', 'u', 's',
        'h1', 'h2', 'h3', 'h4', 'h5', 'h6',
        'ul', 'ol', 'li',
        'blockquote', 'code', 'pre',
        'a',
    ];

    /** @var array<string, list<string>> */
    private const array ALLOWED_ATTRIBUTES = [
        'a' => ['href', 'title', 'target', 'rel'],
    ];

    public function sanitize(string $html): string
    {
        if ($html === '') {
            return '';
        }

        $allowedTagStr = implode('', array_map(fn (string $tag) => "<{$tag}>", self::ALLOWED_TAGS));
        $stripped = strip_tags($html, $allowedTagStr);

        $stripped = $this->sanitizeAttributes($stripped);

        return trim($stripped);
    }

    private function sanitizeAttributes(string $html): string
    {
        return (string) preg_replace_callback(
            '/<(\w+)([^>]*)>/',
            function (array $matches): string {
                $tag = strtolower($matches[1]);
                $attrs = $matches[2];

                if (!isset(self::ALLOWED_ATTRIBUTES[$tag])) {
                    return "<{$tag}>";
                }

                $allowedAttrs = self::ALLOWED_ATTRIBUTES[$tag];
                $cleanAttrs = '';

                foreach ($allowedAttrs as $attr) {
                    if (preg_match('/' . $attr . '=["\']([^"\']*)["\']/', $attrs, $m)) {
                        $value = htmlspecialchars($m[1], \ENT_QUOTES, 'UTF-8');

                        if ($attr === 'href' && $this->isDangerousUrl($value)) {
                            continue;
                        }

                        $cleanAttrs .= " {$attr}=\"{$value}\"";
                    }
                }

                return "<{$tag}{$cleanAttrs}>";
            },
            $html,
        );
    }

    private function isDangerousUrl(string $url): bool
    {
        $scheme = parse_url($url, \PHP_URL_SCHEME);

        if ($scheme === null || $scheme === false) {
            return false;
        }

        return !\in_array(strtolower($scheme), ['http', 'https', 'mailto'], true);
    }
}
