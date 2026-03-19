<?php

declare(strict_types=1);

namespace OneRedPaperclip\Tests\Unit\Action;

use OneRedPaperclip\Action\AcceptOffer;
use OneRedPaperclip\Action\ConfirmTrade;
use OneRedPaperclip\Action\CreateChallenge;
use OneRedPaperclip\Action\CreateOffer;
use OneRedPaperclip\Action\DeclineOffer;
use OneRedPaperclip\Entity\Challenge;
use OneRedPaperclip\Entity\Offer;
use OneRedPaperclip\Entity\Trade;
use OneRedPaperclip\Enum\ChallengeStatus;
use OneRedPaperclip\Enum\ItemRole;
use OneRedPaperclip\Enum\OfferStatus;
use OneRedPaperclip\Enum\TradeStatus;
use OneRedPaperclip\Schema\SchemaInstaller;
use OneRedPaperclip\TradeUpServiceProvider;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use Psr\EventDispatcher\EventDispatcherInterface;
use Waaseyaa\Database\DBALDatabase;
use Waaseyaa\Entity\EntityTypeInterface;
use Waaseyaa\EntityStorage\EntityStorageFactory;
use Waaseyaa\EntityStorage\SqlEntityStorage;

#[CoversClass(CreateOffer::class)]
#[CoversClass(AcceptOffer::class)]
#[CoversClass(DeclineOffer::class)]
#[CoversClass(ConfirmTrade::class)]
final class TradeFlowTest extends TestCase
{
    private EntityStorageFactory $storageFactory;

    /** @var array<string, EntityTypeInterface> */
    private array $entityTypes = [];

    private SqlEntityStorage $challengeStorage;
    private SqlEntityStorage $itemStorage;
    private SqlEntityStorage $offerStorage;
    private SqlEntityStorage $tradeStorage;

    protected function setUp(): void
    {
        $database = DBALDatabase::createSqlite();
        $provider = new TradeUpServiceProvider();
        $provider->register();

        (new SchemaInstaller($database, $provider->getEntityTypes()))->install();

        $dispatcher = new class implements EventDispatcherInterface {
            public function dispatch(object $event): object
            {
                return $event;
            }
        };

        $this->storageFactory = new EntityStorageFactory($database, $dispatcher);

        foreach ($provider->getEntityTypes() as $type) {
            $this->entityTypes[$type->id()] = $type;
        }

        $this->challengeStorage = $this->storageFactory->getStorage($this->entityTypes['challenge']);
        $this->itemStorage = $this->storageFactory->getStorage($this->entityTypes['item']);
        $this->offerStorage = $this->storageFactory->getStorage($this->entityTypes['offer']);
        $this->tradeStorage = $this->storageFactory->getStorage($this->entityTypes['trade']);
    }

    private function createTestChallenge(): Challenge
    {
        $action = new CreateChallenge($this->challengeStorage, $this->itemStorage);

        return $action->execute(1, [
            'title' => 'Test Challenge',
            'slug' => 'test-challenge',
            'start_item' => ['title' => 'Red Paperclip'],
            'goal_item' => ['title' => 'House'],
        ]);
    }

    #[Test]
    public function createOfferCreatesItemAndOffer(): void
    {
        $challenge = $this->createTestChallenge();
        $action = new CreateOffer($this->offerStorage, $this->itemStorage);

        $offer = $action->execute(2, $challenge, [
            'offered_item' => ['title' => 'Fish Pen', 'description' => 'A pen shaped like a fish'],
            'message' => 'I have a great pen!',
        ]);

        $this->assertInstanceOf(Offer::class, $offer);
        $this->assertSame(2, $offer->getFromUserId());
        $this->assertSame((int) $challenge->id(), $offer->getChallengeId());
        $this->assertSame($challenge->getCurrentItemId(), $offer->getForChallengeItemId());
        $this->assertSame(OfferStatus::Pending, $offer->getStatus());
        $this->assertSame('I have a great pen!', $offer->getMessage());
    }

    #[Test]
    public function createOfferCreatesOfferedItem(): void
    {
        $challenge = $this->createTestChallenge();
        $action = new CreateOffer($this->offerStorage, $this->itemStorage);

        $offer = $action->execute(2, $challenge, [
            'offered_item' => ['title' => 'Fish Pen'],
        ]);

        $offeredItem = $this->itemStorage->load($offer->getOfferedItemId());

        $this->assertSame('Fish Pen', $offeredItem->getTitle());
        $this->assertSame(ItemRole::Offered, $offeredItem->getRole());
        $this->assertSame('user', $offeredItem->getItemableType());
        $this->assertSame(2, $offeredItem->getItemableId());
    }

    #[Test]
    public function acceptOfferCreatesTradeAndUpdatesStatus(): void
    {
        $challenge = $this->createTestChallenge();
        $offer = (new CreateOffer($this->offerStorage, $this->itemStorage))
            ->execute(2, $challenge, ['offered_item' => ['title' => 'Pen']]);

        $action = new AcceptOffer($this->offerStorage, $this->tradeStorage, $this->challengeStorage);
        $trade = $action->execute($offer);

        // Offer status updated.
        $reloadedOffer = $this->offerStorage->load($offer->id());
        $this->assertSame(OfferStatus::Accepted, $reloadedOffer->getStatus());

        // Trade created.
        $this->assertInstanceOf(Trade::class, $trade);
        $this->assertSame((int) $challenge->id(), $trade->getChallengeId());
        $this->assertSame((int) $offer->id(), $trade->getOfferId());
        $this->assertSame(1, $trade->getPosition());
        $this->assertSame(TradeStatus::PendingConfirmation, $trade->getStatus());
    }

    #[Test]
    public function acceptOfferAssignsIncrementingPositions(): void
    {
        $challenge = $this->createTestChallenge();
        $createOffer = new CreateOffer($this->offerStorage, $this->itemStorage);
        $acceptOffer = new AcceptOffer($this->offerStorage, $this->tradeStorage, $this->challengeStorage);

        $offer1 = $createOffer->execute(2, $challenge, ['offered_item' => ['title' => 'Pen']]);
        $trade1 = $acceptOffer->execute($offer1);

        $offer2 = $createOffer->execute(3, $challenge, ['offered_item' => ['title' => 'Book']]);
        $trade2 = $acceptOffer->execute($offer2);

        $this->assertSame(1, $trade1->getPosition());
        $this->assertSame(2, $trade2->getPosition());
    }

    #[Test]
    public function declineOfferUpdatesStatus(): void
    {
        $challenge = $this->createTestChallenge();
        $offer = (new CreateOffer($this->offerStorage, $this->itemStorage))
            ->execute(2, $challenge, ['offered_item' => ['title' => 'Pen']]);

        $action = new DeclineOffer($this->offerStorage);
        $declined = $action->execute($offer);

        $this->assertSame(OfferStatus::Declined, $declined->getStatus());

        $reloaded = $this->offerStorage->load($offer->id());
        $this->assertSame(OfferStatus::Declined, $reloaded->getStatus());
    }

    #[Test]
    public function ownerConfirmationCompletesTrade(): void
    {
        $challenge = $this->createTestChallenge();
        $offer = (new CreateOffer($this->offerStorage, $this->itemStorage))
            ->execute(2, $challenge, ['offered_item' => ['title' => 'Pen']]);
        $trade = (new AcceptOffer($this->offerStorage, $this->tradeStorage, $this->challengeStorage))
            ->execute($offer);

        $action = new ConfirmTrade($this->tradeStorage, $this->challengeStorage);
        $confirmed = $action->execute($trade, 'owner', '2026-03-19T12:00:00Z');

        $this->assertSame(TradeStatus::Completed, $confirmed->getStatus());
        $this->assertSame('2026-03-19T12:00:00Z', $confirmed->getConfirmedByOwnerAt());
    }

    #[Test]
    public function ownerConfirmationAdvancesChallenge(): void
    {
        $challenge = $this->createTestChallenge();
        $originalCurrentItem = $challenge->getCurrentItemId();

        $offer = (new CreateOffer($this->offerStorage, $this->itemStorage))
            ->execute(2, $challenge, ['offered_item' => ['title' => 'Pen']]);
        $trade = (new AcceptOffer($this->offerStorage, $this->tradeStorage, $this->challengeStorage))
            ->execute($offer);

        (new ConfirmTrade($this->tradeStorage, $this->challengeStorage))
            ->execute($trade, 'owner', '2026-03-19T12:00:00Z');

        $reloaded = $this->challengeStorage->load($challenge->id());

        $this->assertNotSame($originalCurrentItem, $reloaded->getCurrentItemId());
        $this->assertSame($offer->getOfferedItemId(), $reloaded->getCurrentItemId());
        $this->assertSame(1, $reloaded->getTradesCount());
    }

    #[Test]
    public function offererConfirmationDoesNotCompleteTrade(): void
    {
        $challenge = $this->createTestChallenge();
        $offer = (new CreateOffer($this->offerStorage, $this->itemStorage))
            ->execute(2, $challenge, ['offered_item' => ['title' => 'Pen']]);
        $trade = (new AcceptOffer($this->offerStorage, $this->tradeStorage, $this->challengeStorage))
            ->execute($offer);

        $action = new ConfirmTrade($this->tradeStorage, $this->challengeStorage);
        $confirmed = $action->execute($trade, 'offerer', '2026-03-19T11:00:00Z');

        $this->assertSame(TradeStatus::PendingConfirmation, $confirmed->getStatus());
        $this->assertSame('2026-03-19T11:00:00Z', $confirmed->getConfirmedByOffererAt());
        $this->assertNull($confirmed->getConfirmedByOwnerAt());
    }

    #[Test]
    public function challengeCompletesWhenGoalReached(): void
    {
        $challenge = $this->createTestChallenge();
        $goalItemId = $challenge->getGoalItemId();

        // Create an offer where the offered item happens to be the goal item.
        // We'll simulate this by creating an offer, accepting it, then manually
        // setting the offered_item_id on the trade to match the goal.
        $offer = (new CreateOffer($this->offerStorage, $this->itemStorage))
            ->execute(2, $challenge, ['offered_item' => ['title' => 'The Goal Item']]);
        $trade = (new AcceptOffer($this->offerStorage, $this->tradeStorage, $this->challengeStorage))
            ->execute($offer);

        // Override offered_item_id to match goal for this test.
        $trade->set('offered_item_id', $goalItemId);
        $this->tradeStorage->save($trade);

        (new ConfirmTrade($this->tradeStorage, $this->challengeStorage))
            ->execute($trade, 'owner', '2026-03-19T15:00:00Z');

        $reloaded = $this->challengeStorage->load($challenge->id());

        $this->assertSame(ChallengeStatus::Completed, $reloaded->getStatus());
        $this->assertSame($goalItemId, $reloaded->getCurrentItemId());
    }

    #[Test]
    public function fullTradeUpFlow(): void
    {
        // 1. Owner creates a challenge.
        $challenge = $this->createTestChallenge();
        $this->assertSame(ChallengeStatus::Active, $challenge->getStatus());

        // 2. Another user makes an offer.
        $offer = (new CreateOffer($this->offerStorage, $this->itemStorage))
            ->execute(2, $challenge, [
                'offered_item' => ['title' => 'Fish Pen'],
                'message' => 'Want to trade?',
            ]);
        $this->assertSame(OfferStatus::Pending, $offer->getStatus());

        // 3. Owner accepts the offer.
        $trade = (new AcceptOffer($this->offerStorage, $this->tradeStorage, $this->challengeStorage))
            ->execute($offer);
        $this->assertSame(TradeStatus::PendingConfirmation, $trade->getStatus());
        $this->assertSame(1, $trade->getPosition());

        // 4. Offerer confirms.
        (new ConfirmTrade($this->tradeStorage, $this->challengeStorage))
            ->execute($trade, 'offerer', '2026-03-19T10:00:00Z');
        $trade = $this->tradeStorage->load($trade->id());
        $this->assertSame(TradeStatus::PendingConfirmation, $trade->getStatus());

        // 5. Owner confirms — trade completes, challenge advances.
        (new ConfirmTrade($this->tradeStorage, $this->challengeStorage))
            ->execute($trade, 'owner', '2026-03-19T11:00:00Z');
        $trade = $this->tradeStorage->load($trade->id());
        $this->assertSame(TradeStatus::Completed, $trade->getStatus());

        $reloaded = $this->challengeStorage->load($challenge->id());
        $this->assertSame($offer->getOfferedItemId(), $reloaded->getCurrentItemId());
        $this->assertSame(1, $reloaded->getTradesCount());
    }
}
