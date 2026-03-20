<?php

declare(strict_types=1);

namespace OneRedPaperclip\Http\Controller;

use OneRedPaperclip\Action\ConfirmTrade;
use OneRedPaperclip\Auth\AuthService;
use OneRedPaperclip\Entity\Challenge;
use OneRedPaperclip\Entity\Offer;
use OneRedPaperclip\Entity\Trade;
use OneRedPaperclip\Policy\TradePolicy;
use Waaseyaa\EntityStorage\SqlEntityStorage;
use Waaseyaa\Inertia\Inertia;
use Waaseyaa\Inertia\InertiaResponse;

final class TradeController
{
    public function __construct(
        private readonly SqlEntityStorage $tradeStorage,
        private readonly SqlEntityStorage $offerStorage,
        private readonly SqlEntityStorage $challengeStorage,
        private readonly AuthService $auth,
    ) {}

    /**
     * @param array<string, mixed> $data
     */
    public function update(int $tradeId, array $data): InertiaResponse
    {
        /** @var Trade $trade */
        $trade = $this->tradeStorage->load($tradeId);
        /** @var Challenge $challenge */
        $challenge = $this->challengeStorage->load($trade->getChallengeId());
        $user = $this->auth->currentUser();

        $policy = new TradePolicy();
        if (!$policy->update((int) $user->id(), $trade, $challenge)) {
            return Inertia::render('errors/Forbidden', []);
        }

        // Update allowed fields on the trade's offered item.
        // Full implementation would update the item via itemStorage.
        $this->tradeStorage->save($trade);

        return Inertia::render('challenges/Show', [
            'challenge' => $challenge->toArray(),
        ]);
    }

    public function confirm(int $tradeId): InertiaResponse
    {
        /** @var Trade $trade */
        $trade = $this->tradeStorage->load($tradeId);
        /** @var Offer $offer */
        $offer = $this->offerStorage->load($trade->getOfferId());
        /** @var Challenge $challenge */
        $challenge = $this->challengeStorage->load($trade->getChallengeId());
        $user = $this->auth->currentUser();

        $policy = new TradePolicy();
        if (!$policy->confirm((int) $user->id(), $trade, $offer, $challenge)) {
            return Inertia::render('errors/Forbidden', []);
        }

        $confirmerRole = $offer->getFromUserId() === (int) $user->id() ? 'offerer' : 'owner';
        $timestamp = date('Y-m-d\TH:i:s\Z');

        $action = new ConfirmTrade($this->tradeStorage, $this->challengeStorage);
        $action->execute($trade, $confirmerRole, $timestamp);

        return Inertia::render('challenges/Show', [
            'challenge' => $this->challengeStorage->load($challenge->id())->toArray(),
        ]);
    }
}
