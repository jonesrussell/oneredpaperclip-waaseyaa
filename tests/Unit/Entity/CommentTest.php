<?php

declare(strict_types=1);

namespace OneRedPaperclip\Tests\Unit\Entity;

use OneRedPaperclip\Entity\Comment;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

#[CoversClass(Comment::class)]
final class CommentTest extends TestCase
{
    #[Test]
    public function entityTypeIdIsComment(): void
    {
        $comment = new Comment([]);

        $this->assertSame('comment', $comment->getEntityTypeId());
    }

    #[Test]
    public function getBodyReturnsBody(): void
    {
        $comment = new Comment(['body' => 'Great trade!']);

        $this->assertSame('Great trade!', $comment->getBody());
    }

    #[Test]
    public function getUserIdReturnsUserId(): void
    {
        $comment = new Comment(['user_id' => 5]);

        $this->assertSame(5, $comment->getUserId());
    }

    #[Test]
    public function getParentIdReturnsNullForTopLevel(): void
    {
        $comment = new Comment(['body' => 'Top level']);

        $this->assertNull($comment->getParentId());
    }

    #[Test]
    public function getParentIdReturnsParentIdForReply(): void
    {
        $comment = new Comment(['body' => 'Reply', 'parent_id' => 10]);

        $this->assertSame(10, $comment->getParentId());
    }

    #[Test]
    public function getCommentableTypeReturnsType(): void
    {
        $comment = new Comment(['body' => 'Test', 'commentable_type' => 'challenge']);

        $this->assertSame('challenge', $comment->getCommentableType());
    }

    #[Test]
    public function getCommentableIdReturnsId(): void
    {
        $comment = new Comment(['body' => 'Test', 'commentable_id' => 3]);

        $this->assertSame(3, $comment->getCommentableId());
    }

    #[Test]
    public function labelReturnsTruncatedBody(): void
    {
        $comment = new Comment(['body' => 'Great trade!']);

        $this->assertSame('Great trade!', $comment->label());
    }

    #[Test]
    public function labelReturnsFallbackWhenBodyEmpty(): void
    {
        $comment = new Comment([]);

        $this->assertSame('Comment #new', $comment->label());
    }
}
