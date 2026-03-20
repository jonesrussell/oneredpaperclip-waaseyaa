<?php

declare(strict_types=1);

namespace OneRedPaperclip\Queue;

use OneRedPaperclip\Entity\Notification;
use Waaseyaa\EntityStorage\SqlEntityStorage;

/**
 * Dispatches notifications synchronously or queues them.
 *
 * In sync mode (default for now), notifications are saved immediately.
 * When queue infrastructure is wired, this will push SendNotificationJob
 * to the queue instead.
 */
final class NotificationDispatcher
{
    /** @var list<Notification> */
    private array $dispatched = [];

    public function __construct(
        private readonly SqlEntityStorage $notificationStorage,
    ) {}

    public function dispatch(Notification $notification): void
    {
        $this->notificationStorage->save($notification);
        $this->dispatched[] = $notification;
    }

    /**
     * Dispatch multiple notifications.
     *
     * @param list<Notification> $notifications
     */
    public function dispatchMany(array $notifications): void
    {
        foreach ($notifications as $notification) {
            $this->dispatch($notification);
        }
    }

    /** @return list<Notification> */
    public function getDispatched(): array
    {
        return $this->dispatched;
    }
}
