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
        'label' => 'label',
    ];

    /** @param array<string, mixed> $values */
    public function __construct(array $values = [])
    {
        if (!array_key_exists('status', $values)) {
            $values['status'] = OfferStatus::Pending->value;
        }

        parent::__construct($values, $this->entityTypeId, $this->entityKeys);
    }

    public function label(): string
    {
        return 'Offer #' . ($this->id() ?? 'new');
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

    public function getFromUserId(): ?int
    {
        $val = $this->get('from_user_id');

        return $val !== null ? (int) $val : null;
    }

    public function getChallengeId(): ?int
    {
        $val = $this->get('challenge_id');

        return $val !== null ? (int) $val : null;
    }

    public function getOfferedItemId(): ?int
    {
        $val = $this->get('offered_item_id');

        return $val !== null ? (int) $val : null;
    }

    public function getForChallengeItemId(): ?int
    {
        $val = $this->get('for_challenge_item_id');

        return $val !== null ? (int) $val : null;
    }

    public function getMessage(): string
    {
        return (string) ($this->get('message') ?? '');
    }

    public function getExpiresAt(): ?string
    {
        return $this->get('expires_at');
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
