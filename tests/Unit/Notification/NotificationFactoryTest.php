<?php

declare(strict_types=1);

namespace OneRedPaperclip\Tests\Unit\Notification;

use OneRedPaperclip\Entity\Challenge;
use OneRedPaperclip\Entity\Notification;
use OneRedPaperclip\Entity\Offer;
use OneRedPaperclip\Entity\Trade;
use OneRedPaperclip\Notification\NotificationFactory;
use OneRedPaperclip\Notification\NotificationType;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

#[CoversClass(NotificationFactory::class)]
final class NotificationFactoryTest extends TestCase
{
    private NotificationFactory $factory;
    private Challenge $challenge;
    private Offer $offer;
    private Trade $trade;

    protected function setUp(): void
    {
        $this->factory = new NotificationFactory();
        $this->challenge = new Challenge(['id' => 1, 'title' => 'Test Challenge', 'user_id' => 10]);
        $this->offer = new Offer(['id' => 5, 'from_user_id' => 20, 'challenge_id' => 1]);
        $this->trade = new Trade(['id' => 3, 'challenge_id' => 1, 'offer_id' => 5]);
    }

    #[Test]
    public function offerReceivedCreatesNotification(): void
    {
        $notification = $this->factory->offerReceived(10, $this->offer, $this->challenge);

        $this->assertInstanceOf(Notification::class, $notification);
        $this->assertSame(10, $notification->getUserId());
        $this->assertSame(NotificationType::OfferReceived->value, $notification->getType());

        $data = $notification->getData();
        $this->assertSame(5, $data['offer_id']);
        $this->assertSame(1, $data['challenge_id']);
        $this->assertSame('Test Challenge', $data['challenge_title']);
    }

    #[Test]
    public function offerAcceptedCreatesNotification(): void
    {
        $notification = $this->factory->offerAccepted(20, $this->offer, $this->trade, $this->challenge);

        $this->assertSame(20, $notification->getUserId());
        $this->assertSame(NotificationType::OfferAccepted->value, $notification->getType());

        $data = $notification->getData();
        $this->assertSame(5, $data['offer_id']);
        $this->assertSame(3, $data['trade_id']);
    }

    #[Test]
    public function offerDeclinedCreatesNotification(): void
    {
        $notification = $this->factory->offerDeclined(20, $this->offer, $this->challenge);

        $this->assertSame(NotificationType::OfferDeclined->value, $notification->getType());
    }

    #[Test]
    public function tradePendingConfirmationCreatesNotification(): void
    {
        $notification = $this->factory->tradePendingConfirmation(10, $this->trade, $this->challenge, 20);

        $this->assertSame(NotificationType::TradePendingConfirmation->value, $notification->getType());

        $data = $notification->getData();
        $this->assertSame(20, $data['confirmed_by_user_id']);
    }

    #[Test]
    public function tradeCompletedCreatesNotification(): void
    {
        $notification = $this->factory->tradeCompleted(20, $this->trade, $this->challenge);

        $this->assertSame(NotificationType::TradeCompleted->value, $notification->getType());
    }

    #[Test]
    public function challengeCompletedCreatesNotification(): void
    {
        $notification = $this->factory->challengeCompleted(10, $this->challenge);

        $this->assertSame(NotificationType::ChallengeCompleted->value, $notification->getType());

        $data = $notification->getData();
        $this->assertSame('Test Challenge', $data['challenge_title']);
    }

    #[Test]
    public function allSixTypesAreCovered(): void
    {
        $types = array_map(fn ($t) => $t->value, NotificationType::cases());

        $this->assertSame([
            'offer_received',
            'offer_accepted',
            'offer_declined',
            'trade_pending_confirmation',
            'trade_completed',
            'challenge_completed',
        ], $types);
    }
}
