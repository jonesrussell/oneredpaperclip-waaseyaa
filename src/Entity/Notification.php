<?php

declare(strict_types=1);

namespace OneRedPaperclip\Entity;

use Waaseyaa\Entity\ContentEntityBase;

final class Notification extends ContentEntityBase
{
    protected string $entityTypeId = 'notification';

    protected array $entityKeys = [
        'id' => 'id',
        'uuid' => 'uuid',
        'label' => 'type',
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

    public function getType(): string
    {
        return (string) ($this->get('type') ?? '');
    }

    /** @return array<string, mixed> */
    public function getData(): array
    {
        $data = $this->get('data');

        if (\is_array($data)) {
            return $data;
        }

        if (\is_string($data)) {
            return json_decode($data, true) ?? [];
        }

        return [];
    }

    public function getReadAt(): ?string
    {
        return $this->get('read_at');
    }

    public function isUnread(): bool
    {
        return $this->getReadAt() === null;
    }

    public function markAsRead(string $timestamp): static
    {
        $this->set('read_at', $timestamp);

        return $this;
    }
}
