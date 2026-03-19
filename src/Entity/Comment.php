<?php

declare(strict_types=1);

namespace OneRedPaperclip\Entity;

use Waaseyaa\Entity\ContentEntityBase;

final class Comment extends ContentEntityBase
{
    protected string $entityTypeId = 'comment';

    protected array $entityKeys = [
        'id' => 'id',
        'uuid' => 'uuid',
        'label' => 'body',
    ];

    /** @param array<string, mixed> $values */
    public function __construct(array $values = [])
    {
        parent::__construct($values, $this->entityTypeId, $this->entityKeys);
    }

    public function getBody(): string
    {
        return (string) ($this->get('body') ?? '');
    }

    public function getUserId(): ?int
    {
        $val = $this->get('user_id');

        return $val !== null ? (int) $val : null;
    }

    public function getParentId(): ?int
    {
        $val = $this->get('parent_id');

        return $val !== null ? (int) $val : null;
    }

    public function getCommentableType(): string
    {
        return (string) ($this->get('commentable_type') ?? '');
    }

    public function getCommentableId(): ?int
    {
        $val = $this->get('commentable_id');

        return $val !== null ? (int) $val : null;
    }
}
