<?php

declare(strict_types=1);

namespace OneRedPaperclip\Tests\Unit\Entity;

use OneRedPaperclip\Entity\Trade;
use OneRedPaperclip\Enum\TradeStatus;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

#[CoversClass(Trade::class)]
final class TradeTest extends TestCase
{
    #[Test]
    public function entityTypeIdIsTrade(): void
    {
        $trade = new Trade([]);

        $this->assertSame('trade', $trade->getEntityTypeId());
    }

    #[Test]
    public function defaultStatusIsPendingConfirmation(): void
    {
        $trade = new Trade([]);

        $this->assertSame(TradeStatus::PendingConfirmation, $trade->getStatus());
    }

    #[Test]
    public function setStatusUpdatesStatus(): void
    {
        $trade = new Trade([]);
        $trade->setStatus(TradeStatus::Completed);

        $this->assertSame(TradeStatus::Completed, $trade->getStatus());
    }

    #[Test]
    public function getChallengeIdReturnsChallengeId(): void
    {
        $trade = new Trade(['challenge_id' => 5]);

        $this->assertSame(5, $trade->getChallengeId());
    }

    #[Test]
    public function getOfferIdReturnsOfferId(): void
    {
        $trade = new Trade(['offer_id' => 8]);

        $this->assertSame(8, $trade->getOfferId());
    }

    #[Test]
    public function getPositionReturnsPosition(): void
    {
        $trade = new Trade(['position' => 3]);

        $this->assertSame(3, $trade->getPosition());
    }

    #[Test]
    public function confirmByOwnerSetsTimestamp(): void
    {
        $trade = new Trade([]);
        $now = '2026-03-19 12:00:00';
        $trade->confirmByOwner($now);

        $this->assertSame($now, $trade->getConfirmedByOwnerAt());
    }

    #[Test]
    public function confirmByOffererSetsTimestamp(): void
    {
        $trade = new Trade([]);
        $now = '2026-03-19 12:00:00';
        $trade->confirmByOfferer($now);

        $this->assertSame($now, $trade->getConfirmedByOffererAt());
    }

    #[Test]
    public function confirmationsAreNullByDefault(): void
    {
        $trade = new Trade([]);

        $this->assertNull($trade->getConfirmedByOwnerAt());
        $this->assertNull($trade->getConfirmedByOffererAt());
    }

    #[Test]
    public function labelReturnsTradeLabel(): void
    {
        $trade = new Trade([]);

        $this->assertSame('Trade #new', $trade->label());
    }
}
