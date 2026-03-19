<?php

declare(strict_types=1);

namespace OneRedPaperclip\Entity;

use Waaseyaa\Entity\ContentEntityBase;

final class Category extends ContentEntityBase
{
    protected string $entityTypeId = 'category';

    protected array $entityKeys = [
        'id' => 'id',
        'uuid' => 'uuid',
        'label' => 'name',
    ];

    /** @param array<string, mixed> $values */
    public function __construct(array $values = [])
    {
        parent::__construct($values, $this->entityTypeId, $this->entityKeys);
    }

    public function getName(): string
    {
        return (string) ($this->get('name') ?? '');
    }

    public function setName(string $name): static
    {
        $this->set('name', $name);

        return $this;
    }

    public function getSlug(): string
    {
        return (string) ($this->get('slug') ?? '');
    }

    public function setSlug(string $slug): static
    {
        $this->set('slug', $slug);

        return $this;
    }

    public function getCreatedAt(): ?string
    {
        return $this->get('created_at');
    }

    public function getUpdatedAt(): ?string
    {
        return $this->get('updated_at');
    }
}
