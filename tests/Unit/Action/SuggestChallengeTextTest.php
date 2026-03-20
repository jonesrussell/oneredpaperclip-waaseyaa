<?php

declare(strict_types=1);

namespace OneRedPaperclip\Tests\Unit\Action;

use OneRedPaperclip\Action\SuggestChallengeText;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

#[CoversClass(SuggestChallengeText::class)]
final class SuggestChallengeTextTest extends TestCase
{
    private SuggestChallengeText $action;

    protected function setUp(): void
    {
        $this->action = new SuggestChallengeText();
    }

    #[Test]
    public function suggestsStartItemText(): void
    {
        $result = $this->action->execute('start_item', '', 'paperclip');

        $this->assertArrayHasKey('suggestion', $result);
        $this->assertStringContainsString('paperclip', $result['suggestion']);
    }

    #[Test]
    public function suggestsGoalItemText(): void
    {
        $result = $this->action->execute('goal_item', '', 'house');

        $this->assertStringContainsString('house', $result['suggestion']);
    }

    #[Test]
    public function suggestsStoryText(): void
    {
        $result = $this->action->execute('story');

        $this->assertNotEmpty($result['suggestion']);
    }

    #[Test]
    public function storyAppendsToExistingText(): void
    {
        $result = $this->action->execute('story', 'My story so far.');

        $this->assertStringStartsWith('My story so far.', $result['suggestion']);
    }

    #[Test]
    public function defaultSuggestionsNonEmpty(): void
    {
        $this->assertNotEmpty($this->action->execute('start_item')['suggestion']);
        $this->assertNotEmpty($this->action->execute('goal_item')['suggestion']);
        $this->assertNotEmpty($this->action->execute('story')['suggestion']);
    }
}
