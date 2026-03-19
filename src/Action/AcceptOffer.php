<?php

declare(strict_types=1);

namespace OneRedPaperclip\Action;

use OneRedPaperclip\Entity\Offer;
use OneRedPaperclip\Entity\Trade;
use OneRedPaperclip\Enum\OfferStatus;
use OneRedPaperclip\Enum\TradeStatus;
use Waaseyaa\EntityStorage\SqlEntityStorage;

final class AcceptOffer
{
    public function __construct(
        private readonly SqlEntityStorage $offerStorage,
        private readonly SqlEntityStorage $tradeStorage,
        private readonly SqlEntityStorage $challengeStorage,
    ) {}

    public function execute(Offer $offer): Trade
    {
        $offer->setStatus(OfferStatus::Accepted);
        $this->offerStorage->save($offer);

        $challenge = $this->challengeStorage->load($offer->getChallengeId());
        $position = $this->nextPosition((int) $challenge->id());

        $trade = new Trade([
            'challenge_id' => $offer->getChallengeId(),
            'offer_id' => $offer->id(),
            'position' => $position,
            'offered_item_id' => $offer->getOfferedItemId(),
            'received_item_id' => $offer->getForChallengeItemId(),
            'status' => TradeStatus::PendingConfirmation->value,
        ]);
        $this->tradeStorage->save($trade);

        return $trade;
    }

    private function nextPosition(int $challengeId): int
    {
        // Count existing trades for this challenge to determine next position.
        $result = $this->tradeStorage->getQuery()
            ->condition('challenge_id', $challengeId)
            ->execute();

        return \count($result) + 1;
    }
}
