<?php

declare(strict_types=1);

namespace OneRedPaperclip\Entity;

use Waaseyaa\Entity\ContentEntityBase;

final class Follow extends ContentEntityBase
{
    protected string $entityTypeId = 'follow';

    protected array $entityKeys = [
        'id' => 'id',
        'uuid' => 'uuid',
        'label' => 'id',
    ];

    /** @param array<string, mixed> $values */
    public function __construct(array $values = [])
    {
        parent::__construct($values, $this->entityTypeId, $this->entityKeys);
    }

    public function getUserId(): ?int
    {
        $val = $this->get('user_id');

        return $val !== null ? (int) $val : null;
    }

    public function getFollowableType(): string
    {
        return (string) ($this->get('followable_type') ?? '');
    }

    public function getFollowableId(): ?int
    {
        $val = $this->get('followable_id');

        return $val !== null ? (int) $val : null;
    }
}
