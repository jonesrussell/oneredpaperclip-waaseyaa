<?php

declare(strict_types=1);

namespace OneRedPaperclip\Tests\Unit\Service;

use OneRedPaperclip\Service\HtmlSanitizer;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

#[CoversClass(HtmlSanitizer::class)]
final class HtmlSanitizerTest extends TestCase
{
    private HtmlSanitizer $sanitizer;

    protected function setUp(): void
    {
        $this->sanitizer = new HtmlSanitizer();
    }

    #[Test]
    public function preservesSafeTags(): void
    {
        $html = '<p>Hello <strong>world</strong></p>';

        $this->assertSame('<p>Hello <strong>world</strong></p>', $this->sanitizer->sanitize($html));
    }

    #[Test]
    public function stripsScriptTags(): void
    {
        $html = '<p>Hello</p><script>alert("xss")</script>';

        $this->assertSame('<p>Hello</p>alert("xss")', $this->sanitizer->sanitize($html));
    }

    #[Test]
    public function stripsStyleTags(): void
    {
        $html = '<p>Hello</p><style>body{display:none}</style>';

        $this->assertSame('<p>Hello</p>body{display:none}', $this->sanitizer->sanitize($html));
    }

    #[Test]
    public function preservesLinks(): void
    {
        $html = '<a href="https://example.com" title="Link">Click</a>';

        $this->assertSame('<a href="https://example.com" title="Link">Click</a>', $this->sanitizer->sanitize($html));
    }

    #[Test]
    public function stripsJavascriptUrls(): void
    {
        $html = '<a href="javascript:alert(1)">Click</a>';

        $result = $this->sanitizer->sanitize($html);

        $this->assertStringNotContainsString('javascript:', $result);
    }

    #[Test]
    public function stripsEventHandlers(): void
    {
        $html = '<p onclick="alert(1)">Click</p>';

        $this->assertSame('<p>Click</p>', $this->sanitizer->sanitize($html));
    }

    #[Test]
    public function preservesFormattingTags(): void
    {
        $html = '<em>italic</em> <u>underline</u> <s>strike</s>';

        $this->assertSame('<em>italic</em> <u>underline</u> <s>strike</s>', $this->sanitizer->sanitize($html));
    }

    #[Test]
    public function preservesLists(): void
    {
        $html = '<ul><li>One</li><li>Two</li></ul>';

        $this->assertSame('<ul><li>One</li><li>Two</li></ul>', $this->sanitizer->sanitize($html));
    }

    #[Test]
    public function returnsEmptyForEmptyInput(): void
    {
        $this->assertSame('', $this->sanitizer->sanitize(''));
    }
}
