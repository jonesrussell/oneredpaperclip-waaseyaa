<?php

declare(strict_types=1);

namespace OneRedPaperclip\Http\Controller;

use OneRedPaperclip\Action\AcceptOffer;
use OneRedPaperclip\Action\CreateOffer;
use OneRedPaperclip\Action\DeclineOffer;
use OneRedPaperclip\Auth\AuthService;
use OneRedPaperclip\Entity\Challenge;
use OneRedPaperclip\Entity\Offer;
use OneRedPaperclip\Policy\OfferPolicy;
use OneRedPaperclip\Validation\StoreOfferValidator;
use Waaseyaa\EntityStorage\SqlEntityStorage;
use Waaseyaa\Inertia\Inertia;
use Waaseyaa\Inertia\InertiaResponse;

final class OfferController
{
    public function __construct(
        private readonly SqlEntityStorage $offerStorage,
        private readonly SqlEntityStorage $itemStorage,
        private readonly SqlEntityStorage $challengeStorage,
        private readonly SqlEntityStorage $tradeStorage,
        private readonly AuthService $auth,
    ) {}

    /**
     * @param array<string, mixed> $data
     */
    public function store(int $challengeId, array $data): InertiaResponse|array
    {
        $validator = new StoreOfferValidator();
        $result = $validator->validate($data);

        if ($result->fails()) {
            return ['errors' => $result->errors()];
        }

        /** @var Challenge $challenge */
        $challenge = $this->challengeStorage->load($challengeId);
        $user = $this->auth->currentUser();

        $policy = new OfferPolicy();
        if (!$policy->create((int) $user->id(), $challenge)) {
            return Inertia::render('errors/Forbidden', []);
        }

        $action = new CreateOffer($this->offerStorage, $this->itemStorage);
        $action->execute((int) $user->id(), $challenge, $data);

        return Inertia::render('challenges/Show', [
            'challenge' => $challenge->toArray(),
        ]);
    }

    public function accept(int $offerId): InertiaResponse
    {
        /** @var Offer $offer */
        $offer = $this->offerStorage->load($offerId);
        /** @var Challenge $challenge */
        $challenge = $this->challengeStorage->load($offer->getChallengeId());
        $user = $this->auth->currentUser();

        $policy = new OfferPolicy();
        if (!$policy->accept((int) $user->id(), $offer, $challenge)) {
            return Inertia::render('errors/Forbidden', []);
        }

        $action = new AcceptOffer($this->offerStorage, $this->tradeStorage, $this->challengeStorage);
        $action->execute($offer);

        return Inertia::render('challenges/Show', [
            'challenge' => $challenge->toArray(),
        ]);
    }

    public function decline(int $offerId): InertiaResponse
    {
        /** @var Offer $offer */
        $offer = $this->offerStorage->load($offerId);
        /** @var Challenge $challenge */
        $challenge = $this->challengeStorage->load($offer->getChallengeId());
        $user = $this->auth->currentUser();

        $policy = new OfferPolicy();
        if (!$policy->decline((int) $user->id(), $offer, $challenge)) {
            return Inertia::render('errors/Forbidden', []);
        }

        $action = new DeclineOffer($this->offerStorage);
        $action->execute($offer);

        return Inertia::render('challenges/Show', [
            'challenge' => $challenge->toArray(),
        ]);
    }
}
