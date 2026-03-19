<?php

declare(strict_types=1);

namespace OneRedPaperclip\Tests\Unit\Policy;

use OneRedPaperclip\Entity\Challenge;
use OneRedPaperclip\Entity\Offer;
use OneRedPaperclip\Enum\OfferStatus;
use OneRedPaperclip\Policy\OfferPolicy;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

#[CoversClass(OfferPolicy::class)]
final class OfferPolicyTest extends TestCase
{
    private OfferPolicy $policy;

    protected function setUp(): void
    {
        $this->policy = new OfferPolicy();
    }

    #[Test]
    public function ownerCannotCreateOfferOnOwnChallenge(): void
    {
        $challenge = new Challenge(['title' => 'Test', 'user_id' => 1]);

        $this->assertFalse($this->policy->create(1, $challenge));
    }

    #[Test]
    public function otherUserCanCreateOffer(): void
    {
        $challenge = new Challenge(['title' => 'Test', 'user_id' => 1]);

        $this->assertTrue($this->policy->create(2, $challenge));
    }

    #[Test]
    public function ownerCanAcceptPendingOfferTargetingCurrentItem(): void
    {
        $challenge = new Challenge(['title' => 'Test', 'user_id' => 1, 'current_item_id' => 10]);
        $offer = new Offer(['status' => OfferStatus::Pending->value, 'for_challenge_item_id' => 10]);

        $this->assertTrue($this->policy->accept(1, $offer, $challenge));
    }

    #[Test]
    public function nonOwnerCannotAccept(): void
    {
        $challenge = new Challenge(['title' => 'Test', 'user_id' => 1, 'current_item_id' => 10]);
        $offer = new Offer(['status' => OfferStatus::Pending->value, 'for_challenge_item_id' => 10]);

        $this->assertFalse($this->policy->accept(2, $offer, $challenge));
    }

    #[Test]
    public function cannotAcceptNonPendingOffer(): void
    {
        $challenge = new Challenge(['title' => 'Test', 'user_id' => 1, 'current_item_id' => 10]);
        $offer = new Offer(['status' => OfferStatus::Accepted->value, 'for_challenge_item_id' => 10]);

        $this->assertFalse($this->policy->accept(1, $offer, $challenge));
    }

    #[Test]
    public function cannotAcceptStaleOffer(): void
    {
        $challenge = new Challenge(['title' => 'Test', 'user_id' => 1, 'current_item_id' => 20]);
        $offer = new Offer(['status' => OfferStatus::Pending->value, 'for_challenge_item_id' => 10]);

        $this->assertFalse($this->policy->accept(1, $offer, $challenge));
    }

    #[Test]
    public function ownerCanDeclinePendingOffer(): void
    {
        $challenge = new Challenge(['title' => 'Test', 'user_id' => 1]);
        $offer = new Offer(['status' => OfferStatus::Pending->value]);

        $this->assertTrue($this->policy->decline(1, $offer, $challenge));
    }

    #[Test]
    public function nonOwnerCannotDecline(): void
    {
        $challenge = new Challenge(['title' => 'Test', 'user_id' => 1]);
        $offer = new Offer(['status' => OfferStatus::Pending->value]);

        $this->assertFalse($this->policy->decline(2, $offer, $challenge));
    }

    #[Test]
    public function cannotDeclineNonPendingOffer(): void
    {
        $challenge = new Challenge(['title' => 'Test', 'user_id' => 1]);
        $offer = new Offer(['status' => OfferStatus::Declined->value]);

        $this->assertFalse($this->policy->decline(1, $offer, $challenge));
    }
}
