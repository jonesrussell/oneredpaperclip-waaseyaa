<?php

declare(strict_types=1);

namespace OneRedPaperclip\Tests\Unit\Validation;

use OneRedPaperclip\Validation\StoreChallengeValidator;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

#[CoversClass(StoreChallengeValidator::class)]
final class StoreChallengeValidatorTest extends TestCase
{
    private StoreChallengeValidator $validator;

    protected function setUp(): void
    {
        $this->validator = new StoreChallengeValidator();
    }

    #[Test]
    public function validDataPasses(): void
    {
        $result = $this->validator->validate([
            'title' => 'My Challenge',
            'slug' => 'my-challenge',
            'start_item' => ['title' => 'Paperclip'],
            'goal_item' => ['title' => 'House'],
        ]);

        $this->assertTrue($result->passes());
    }

    #[Test]
    public function missingTitleFails(): void
    {
        $result = $this->validator->validate([
            'slug' => 'test',
            'start_item' => ['title' => 'Start'],
            'goal_item' => ['title' => 'Goal'],
        ]);

        $this->assertTrue($result->fails());
        $this->assertNotEmpty($result->errorsFor('title'));
    }

    #[Test]
    public function missingSlugFails(): void
    {
        $result = $this->validator->validate([
            'title' => 'Test',
            'start_item' => ['title' => 'Start'],
            'goal_item' => ['title' => 'Goal'],
        ]);

        $this->assertTrue($result->fails());
        $this->assertNotEmpty($result->errorsFor('slug'));
    }

    #[Test]
    public function missingStartItemFails(): void
    {
        $result = $this->validator->validate([
            'title' => 'Test',
            'slug' => 'test',
            'goal_item' => ['title' => 'Goal'],
        ]);

        $this->assertTrue($result->fails());
        $this->assertNotEmpty($result->errorsFor('start_item'));
    }

    #[Test]
    public function missingGoalItemFails(): void
    {
        $result = $this->validator->validate([
            'title' => 'Test',
            'slug' => 'test',
            'start_item' => ['title' => 'Start'],
        ]);

        $this->assertTrue($result->fails());
        $this->assertNotEmpty($result->errorsFor('goal_item'));
    }

    #[Test]
    public function startItemMissingTitleFails(): void
    {
        $result = $this->validator->validate([
            'title' => 'Test',
            'slug' => 'test',
            'start_item' => ['description' => 'No title'],
            'goal_item' => ['title' => 'Goal'],
        ]);

        $this->assertTrue($result->fails());
        $this->assertNotEmpty($result->errorsFor('start_item.title'));
    }

    #[Test]
    public function invalidStatusFails(): void
    {
        $result = $this->validator->validate([
            'title' => 'Test',
            'slug' => 'test',
            'status' => 'invalid',
            'start_item' => ['title' => 'Start'],
            'goal_item' => ['title' => 'Goal'],
        ]);

        $this->assertTrue($result->fails());
        $this->assertNotEmpty($result->errorsFor('status'));
    }

    #[Test]
    public function invalidVisibilityFails(): void
    {
        $result = $this->validator->validate([
            'title' => 'Test',
            'slug' => 'test',
            'visibility' => 'secret',
            'start_item' => ['title' => 'Start'],
            'goal_item' => ['title' => 'Goal'],
        ]);

        $this->assertTrue($result->fails());
        $this->assertNotEmpty($result->errorsFor('visibility'));
    }

    #[Test]
    public function storyTooLongFails(): void
    {
        $result = $this->validator->validate([
            'title' => 'Test',
            'slug' => 'test',
            'story' => str_repeat('a', 2001),
            'start_item' => ['title' => 'Start'],
            'goal_item' => ['title' => 'Goal'],
        ]);

        $this->assertTrue($result->fails());
        $this->assertNotEmpty($result->errorsFor('story'));
    }

    #[Test]
    public function titleTooLongFails(): void
    {
        $result = $this->validator->validate([
            'title' => str_repeat('a', 256),
            'slug' => 'test',
            'start_item' => ['title' => 'Start'],
            'goal_item' => ['title' => 'Goal'],
        ]);

        $this->assertTrue($result->fails());
        $this->assertNotEmpty($result->errorsFor('title'));
    }
}
