<?php

declare(strict_types=1);

namespace OneRedPaperclip\Entity;

use OneRedPaperclip\Enum\TradeStatus;
use Waaseyaa\Entity\ContentEntityBase;

final class Trade extends ContentEntityBase
{
    protected string $entityTypeId = 'trade';

    protected array $entityKeys = [
        'id' => 'id',
        'uuid' => 'uuid',
        'label' => 'label',
    ];

    /** @param array<string, mixed> $values */
    public function __construct(array $values = [])
    {
        if (!array_key_exists('status', $values)) {
            $values['status'] = TradeStatus::PendingConfirmation->value;
        }

        parent::__construct($values, $this->entityTypeId, $this->entityKeys);
    }

    public function label(): string
    {
        return 'Trade #' . ($this->id() ?? 'new');
    }

    public function getStatus(): TradeStatus
    {
        return TradeStatus::from((string) $this->get('status'));
    }

    public function setStatus(TradeStatus $status): static
    {
        $this->set('status', $status->value);

        return $this;
    }

    public function getChallengeId(): ?int
    {
        $val = $this->get('challenge_id');

        return $val !== null ? (int) $val : null;
    }

    public function getOfferId(): ?int
    {
        $val = $this->get('offer_id');

        return $val !== null ? (int) $val : null;
    }

    public function getPosition(): ?int
    {
        $val = $this->get('position');

        return $val !== null ? (int) $val : null;
    }

    public function getConfirmedByOwnerAt(): ?string
    {
        return $this->get('confirmed_by_owner_at');
    }

    public function confirmByOwner(string $timestamp): static
    {
        $this->set('confirmed_by_owner_at', $timestamp);

        return $this;
    }

    public function getConfirmedByOffererAt(): ?string
    {
        return $this->get('confirmed_by_offerer_at');
    }

    public function confirmByOfferer(string $timestamp): static
    {
        $this->set('confirmed_by_offerer_at', $timestamp);

        return $this;
    }

    public function getOfferedItemId(): ?int
    {
        $val = $this->get('offered_item_id');

        return $val !== null ? (int) $val : null;
    }

    public function getReceivedItemId(): ?int
    {
        $val = $this->get('received_item_id');

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
