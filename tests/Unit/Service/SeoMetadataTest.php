<?php

declare(strict_types=1);

namespace OneRedPaperclip\Tests\Unit\Service;

use OneRedPaperclip\Entity\Challenge;
use OneRedPaperclip\Service\SeoMetadata;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

#[CoversClass(SeoMetadata::class)]
final class SeoMetadataTest extends TestCase
{
    private SeoMetadata $seo;

    protected function setUp(): void
    {
        $this->seo = new SeoMetadata();
    }

    #[Test]
    public function challengeTitleIncludesBranding(): void
    {
        $challenge = new Challenge(['title' => 'Red Paperclip', 'story' => 'A trade challenge']);
        $meta = $this->seo->forChallenge($challenge);

        $this->assertStringContainsString('Red Paperclip', $meta['title']);
        $this->assertStringContainsString('One Red Paperclip', $meta['title']);
    }

    #[Test]
    public function challengeDescriptionTruncatesLongStory(): void
    {
        $challenge = new Challenge(['title' => 'Test', 'story' => str_repeat('a', 200)]);
        $meta = $this->seo->forChallenge($challenge);

        $this->assertLessThanOrEqual(160, mb_strlen($meta['description']));
        $this->assertStringEndsWith('...', $meta['description']);
    }

    #[Test]
    public function challengeFallbackDescriptionWhenNoStory(): void
    {
        $challenge = new Challenge(['title' => 'My Challenge']);
        $meta = $this->seo->forChallenge($challenge);

        $this->assertStringContainsString('My Challenge', $meta['description']);
    }

    #[Test]
    public function pageTitleIncludesBranding(): void
    {
        $meta = $this->seo->forPage('About');

        $this->assertSame('About — One Red Paperclip', $meta['title']);
    }

    #[Test]
    public function pageDefaultDescription(): void
    {
        $meta = $this->seo->forPage('Home');

        $this->assertStringContainsString('Trade up', $meta['description']);
    }
}
