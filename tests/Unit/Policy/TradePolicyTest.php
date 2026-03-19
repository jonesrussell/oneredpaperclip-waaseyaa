<?php

declare(strict_types=1);

namespace OneRedPaperclip\Tests\Unit\Policy;

use OneRedPaperclip\Entity\Challenge;
use OneRedPaperclip\Entity\Offer;
use OneRedPaperclip\Entity\Trade;
use OneRedPaperclip\Enum\TradeStatus;
use OneRedPaperclip\Policy\TradePolicy;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

#[CoversClass(TradePolicy::class)]
final class TradePolicyTest extends TestCase
{
    private TradePolicy $policy;

    protected function setUp(): void
    {
        $this->policy = new TradePolicy();
    }

    #[Test]
    public function offererCanConfirm(): void
    {
        $challenge = new Challenge(['title' => 'Test', 'user_id' => 1]);
        $offer = new Offer(['from_user_id' => 2]);
        $trade = new Trade([]);

        $this->assertTrue($this->policy->confirm(2, $trade, $offer, $challenge));
    }

    #[Test]
    public function ownerCanConfirm(): void
    {
        $challenge = new Challenge(['title' => 'Test', 'user_id' => 1]);
        $offer = new Offer(['from_user_id' => 2]);
        $trade = new Trade([]);

        $this->assertTrue($this->policy->confirm(1, $trade, $offer, $challenge));
    }

    #[Test]
    public function unrelatedUserCannotConfirm(): void
    {
        $challenge = new Challenge(['title' => 'Test', 'user_id' => 1]);
        $offer = new Offer(['from_user_id' => 2]);
        $trade = new Trade([]);

        $this->assertFalse($this->policy->confirm(3, $trade, $offer, $challenge));
    }

    #[Test]
    public function ownerCanUpdatePendingTrade(): void
    {
        $challenge = new Challenge(['title' => 'Test', 'user_id' => 1]);
        $trade = new Trade(['status' => TradeStatus::PendingConfirmation->value]);

        $this->assertTrue($this->policy->update(1, $trade, $challenge));
    }

    #[Test]
    public function nonOwnerCannotUpdate(): void
    {
        $challenge = new Challenge(['title' => 'Test', 'user_id' => 1]);
        $trade = new Trade(['status' => TradeStatus::PendingConfirmation->value]);

        $this->assertFalse($this->policy->update(2, $trade, $challenge));
    }

    #[Test]
    public function cannotUpdateCompletedTrade(): void
    {
        $challenge = new Challenge(['title' => 'Test', 'user_id' => 1]);
        $trade = new Trade(['status' => TradeStatus::Completed->value]);

        $this->assertFalse($this->policy->update(1, $trade, $challenge));
    }
}
