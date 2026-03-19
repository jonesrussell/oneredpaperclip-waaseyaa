<?php

declare(strict_types=1);

namespace OneRedPaperclip\Tests\Unit\Entity;

use OneRedPaperclip\Entity\Offer;
use OneRedPaperclip\Enum\OfferStatus;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

#[CoversClass(Offer::class)]
final class OfferTest extends TestCase
{
    #[Test]
    public function entityTypeIdIsOffer(): void
    {
        $offer = new Offer([]);

        $this->assertSame('offer', $offer->getEntityTypeId());
    }

    #[Test]
    public function defaultStatusIsPending(): void
    {
        $offer = new Offer([]);

        $this->assertSame(OfferStatus::Pending, $offer->getStatus());
    }

    #[Test]
    public function setStatusUpdatesStatus(): void
    {
        $offer = new Offer([]);
        $offer->setStatus(OfferStatus::Accepted);

        $this->assertSame(OfferStatus::Accepted, $offer->getStatus());
    }

    #[Test]
    public function getFromUserIdReturnsUserId(): void
    {
        $offer = new Offer(['from_user_id' => 3]);

        $this->assertSame(3, $offer->getFromUserId());
    }

    #[Test]
    public function getChallengeIdReturnsChallengeId(): void
    {
        $offer = new Offer(['challenge_id' => 7]);

        $this->assertSame(7, $offer->getChallengeId());
    }

    #[Test]
    public function getMessageReturnsMessage(): void
    {
        $offer = new Offer(['message' => 'I have a great trade!']);

        $this->assertSame('I have a great trade!', $offer->getMessage());
    }

    #[Test]
    public function getOfferedItemIdReturnsItemId(): void
    {
        $offer = new Offer(['offered_item_id' => 10]);

        $this->assertSame(10, $offer->getOfferedItemId());
    }

    #[Test]
    public function getForChallengeItemIdReturnsTargetItemId(): void
    {
        $offer = new Offer(['for_challenge_item_id' => 15]);

        $this->assertSame(15, $offer->getForChallengeItemId());
    }

    #[Test]
    public function labelReturnsOfferLabel(): void
    {
        $offer = new Offer([]);

        $this->assertSame('Offer #new', $offer->label());
    }
}
