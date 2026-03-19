<?php

declare(strict_types=1);

namespace OneRedPaperclip\Entity;

use OneRedPaperclip\Enum\ChallengeStatus;
use OneRedPaperclip\Enum\ChallengeVisibility;
use Waaseyaa\Entity\ContentEntityBase;

final class Challenge extends ContentEntityBase
{
    protected string $entityTypeId = 'challenge';

    protected array $entityKeys = [
        'id' => 'id',
        'uuid' => 'uuid',
        'label' => 'title',
    ];

    /** @param array<string, mixed> $values */
    public function __construct(array $values = [])
    {
        if (!array_key_exists('status', $values)) {
            $values['status'] = ChallengeStatus::Draft->value;
        }
        if (!array_key_exists('visibility', $values)) {
            $values['visibility'] = ChallengeVisibility::Public->value;
        }

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

    public function getSlug(): string
    {
        return (string) ($this->get('slug') ?? '');
    }

    public function getDescription(): string
    {
        return (string) ($this->get('description') ?? '');
    }

    public function getStatus(): ChallengeStatus
    {
        return ChallengeStatus::from((string) $this->get('status'));
    }

    public function setStatus(ChallengeStatus $status): static
    {
        $this->set('status', $status->value);

        return $this;
    }

    public function getVisibility(): ChallengeVisibility
    {
        return ChallengeVisibility::from((string) $this->get('visibility'));
    }

    public function setVisibility(ChallengeVisibility $visibility): static
    {
        $this->set('visibility', $visibility->value);

        return $this;
    }

    public function getUserId(): ?int
    {
        $val = $this->get('user_id');

        return $val !== null ? (int) $val : null;
    }

    public function getCategoryTid(): ?int
    {
        $val = $this->get('category_tid');

        return $val !== null ? (int) $val : null;
    }

    public function getCurrentItemId(): ?int
    {
        $val = $this->get('current_item_id');

        return $val !== null ? (int) $val : null;
    }

    public function setCurrentItemId(int $id): static
    {
        $this->set('current_item_id', $id);

        return $this;
    }

    public function getGoalItemId(): ?int
    {
        $val = $this->get('goal_item_id');

        return $val !== null ? (int) $val : null;
    }

    public function getDeletedAt(): ?string
    {
        return $this->get('deleted_at');
    }
}
