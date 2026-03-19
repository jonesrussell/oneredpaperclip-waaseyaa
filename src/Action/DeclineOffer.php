<?php

declare(strict_types=1);

namespace OneRedPaperclip\Action;

use OneRedPaperclip\Entity\Offer;
use OneRedPaperclip\Enum\OfferStatus;
use Waaseyaa\EntityStorage\SqlEntityStorage;

final class DeclineOffer
{
    public function __construct(
        private readonly SqlEntityStorage $offerStorage,
    ) {}

    public function execute(Offer $offer): Offer
    {
        $offer->setStatus(OfferStatus::Declined);
        $this->offerStorage->save($offer);

        return $offer;
    }
}
