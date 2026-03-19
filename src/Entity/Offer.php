<?php

declare(strict_types=1);

namespace OneRedPaperclip\Entity;

use OneRedPaperclip\Enum\OfferStatus;
use Waaseyaa\Entity\ContentEntityBase;

final class Offer extends ContentEntityBase
{
    protected string $entityTypeId = 'offer';

    protected array $entityKeys = [
        'id' => 'id',
        'uuid' => 'uuid',
        'label' => 'id',
    ];

    /** @param array<string, mixed> $values */
    public function __construct(array $values = [])
    {
        if (!array_key_exists('status', $values)) {
            $values['status'] = OfferStatus::Pending->value;
        }

        parent::__construct($values, $this->entityTypeId, $this->entityKeys);
    }

    public function getStatus(): OfferStatus
    {
        return OfferStatus::from((string) $this->get('status'));
    }

    public function setStatus(OfferStatus $status): static
    {
        $this->set('status', $status->value);

        return $this;
    }

    public function getUserId(): ?int
    {
        $val = $this->get('user_id');

        return $val !== null ? (int) $val : null;
    }

    public function getChallengeId(): ?int
    {
        $val = $this->get('challenge_id');

        return $val !== null ? (int) $val : null;
    }

    public function getItemId(): ?int
    {
        $val = $this->get('item_id');

        return $val !== null ? (int) $val : null;
    }

    public function getTargetItemId(): ?int
    {
        $val = $this->get('target_item_id');

        return $val !== null ? (int) $val : null;
    }

    public function getMessage(): string
    {
        return (string) ($this->get('message') ?? '');
    }
}
