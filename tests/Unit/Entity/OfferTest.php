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
    public function getUserIdReturnsUserId(): void
    {
        $offer = new Offer(['user_id' => 3]);

        $this->assertSame(3, $offer->getUserId());
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
    public function getItemIdReturnsItemId(): void
    {
        $offer = new Offer(['item_id' => 10]);

        $this->assertSame(10, $offer->getItemId());
    }

    #[Test]
    public function getTargetItemIdReturnsTargetItemId(): void
    {
        $offer = new Offer(['target_item_id' => 15]);

        $this->assertSame(15, $offer->getTargetItemId());
    }
}
