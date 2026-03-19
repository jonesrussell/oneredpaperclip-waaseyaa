<?php

declare(strict_types=1);

namespace OneRedPaperclip\Action;

use OneRedPaperclip\Entity\Challenge;
use OneRedPaperclip\Entity\Trade;
use OneRedPaperclip\Enum\ChallengeStatus;
use OneRedPaperclip\Enum\TradeStatus;
use Waaseyaa\EntityStorage\SqlEntityStorage;

final class ConfirmTrade
{
    public function __construct(
        private readonly SqlEntityStorage $tradeStorage,
        private readonly SqlEntityStorage $challengeStorage,
    ) {}

    /**
     * @param 'owner'|'offerer' $confirmerRole
     */
    public function execute(Trade $trade, string $confirmerRole, string $timestamp): Trade
    {
        if ($confirmerRole === 'owner') {
            $trade->confirmByOwner($timestamp);
            $trade->setStatus(TradeStatus::Completed);
            $this->tradeStorage->save($trade);

            $this->advanceChallenge($trade);
        } else {
            $trade->confirmByOfferer($timestamp);
            $this->tradeStorage->save($trade);
        }

        return $trade;
    }

    private function advanceChallenge(Trade $trade): void
    {
        /** @var Challenge|null $challenge */
        $challenge = $this->challengeStorage->load($trade->getChallengeId());

        if ($challenge === null) {
            return;
        }

        $challenge->setCurrentItemId((int) $trade->getOfferedItemId());

        // Increment trades_count.
        $challenge->set('trades_count', $challenge->getTradesCount() + 1);

        // Check if challenge is complete (current item matches goal).
        if ($challenge->getCurrentItemId() === $challenge->getGoalItemId()) {
            $challenge->setStatus(ChallengeStatus::Completed);
        }

        $this->challengeStorage->save($challenge);
    }
}
