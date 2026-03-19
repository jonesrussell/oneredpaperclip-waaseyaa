<?php

declare(strict_types=1);

namespace OneRedPaperclip\Entity;

use Waaseyaa\Entity\ContentEntityBase;

final class Media extends ContentEntityBase
{
    protected string $entityTypeId = 'media';

    protected array $entityKeys = [
        'id' => 'id',
        'uuid' => 'uuid',
        'label' => 'label',
    ];

    /** @param array<string, mixed> $values */
    public function __construct(array $values = [])
    {
        parent::__construct($values, $this->entityTypeId, $this->entityKeys);
    }

    public function label(): string
    {
        $fileName = $this->getFileName();

        return $fileName !== '' ? $fileName : 'Media #' . ($this->id() ?? 'new');
    }

    public function getModelType(): string
    {
        return (string) ($this->get('model_type') ?? '');
    }

    public function getModelId(): ?int
    {
        $val = $this->get('model_id');

        return $val !== null ? (int) $val : null;
    }

    public function getCollectionName(): ?string
    {
        return $this->get('collection_name');
    }

    public function getFileName(): string
    {
        return (string) ($this->get('file_name') ?? '');
    }

    public function getDisk(): string
    {
        return (string) ($this->get('disk') ?? '');
    }

    public function getPath(): string
    {
        return (string) ($this->get('path') ?? '');
    }

    public function getSize(): ?int
    {
        $val = $this->get('size');

        return $val !== null ? (int) $val : null;
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
