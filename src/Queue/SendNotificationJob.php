<?php

declare(strict_types=1);

namespace OneRedPaperclip\Queue;

use OneRedPaperclip\Entity\Notification;
use Waaseyaa\EntityStorage\SqlEntityStorage;

/**
 * Job that persists a notification entity to storage.
 *
 * In production, this runs asynchronously via the queue worker.
 * The notification entity is created by NotificationFactory and
 * this job handles the actual persistence.
 */
final class SendNotificationJob
{
    public function __construct(
        private readonly Notification $notification,
    ) {}

    public function handle(SqlEntityStorage $notificationStorage): void
    {
        $notificationStorage->save($this->notification);
    }

    public function getNotification(): Notification
    {
        return $this->notification;
    }
}
