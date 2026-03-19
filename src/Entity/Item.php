<?php

declare(strict_types=1);

namespace OneRedPaperclip\Entity;

use OneRedPaperclip\Enum\ItemRole;
use Waaseyaa\Entity\ContentEntityBase;

final class Item extends ContentEntityBase
{
    protected string $entityTypeId = 'item';

    protected array $entityKeys = [
        'id' => 'id',
        'uuid' => 'uuid',
        'label' => 'title',
    ];

    /** @param array<string, mixed> $values */
    public function __construct(array $values = [])
    {
        parent::__construct($values, $this->entityTypeId, $this->entityKeys);
    }

    public function getTitle(): string
    {
        return (string) ($this->get('title') ?? '');
    }

    public function setTitle(string $title): static
    {
        $this->set('title', $title);

        return $this;
    }

    public function getDescription(): string
    {
        return (string) ($this->get('description') ?? '');
    }

    public function getRole(): ?ItemRole
    {
        $val = $this->get('role');

        return $val !== null ? ItemRole::from((string) $val) : null;
    }

    public function getItemableType(): string
    {
        return (string) ($this->get('itemable_type') ?? '');
    }

    public function getItemableId(): ?int
    {
        $val = $this->get('itemable_id');

        return $val !== null ? (int) $val : null;
    }

    public function getEstimatedValue(): ?string
    {
        return $this->get('estimated_value');
    }
}
