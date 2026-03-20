<?php

declare(strict_types=1);

namespace OneRedPaperclip\Http\Controller;

use OneRedPaperclip\Auth\AuthService;
use OneRedPaperclip\Entity\Notification;
use Waaseyaa\EntityStorage\SqlEntityStorage;
use Waaseyaa\Inertia\Inertia;
use Waaseyaa\Inertia\InertiaResponse;

final class NotificationController
{
    public function __construct(
        private readonly SqlEntityStorage $notificationStorage,
        private readonly AuthService $auth,
    ) {}

    public function index(): InertiaResponse
    {
        $user = $this->auth->currentUser();
        $ids = $this->notificationStorage->getQuery()
            ->condition('user_id', (int) $user->id())
            ->execute();

        $notifications = [];
        foreach ($ids as $id) {
            $n = $this->notificationStorage->load($id);
            if ($n instanceof Notification) {
                $notifications[] = $n->toArray();
            }
        }

        return Inertia::render('notifications/Index', [
            'notifications' => $notifications,
        ]);
    }

    /** @return array{count: int} */
    public function unreadCount(): array
    {
        $user = $this->auth->currentUser();
        $ids = $this->notificationStorage->getQuery()
            ->condition('user_id', (int) $user->id())
            ->condition('read_at', null, 'IS NULL')
            ->execute();

        return ['count' => \count($ids)];
    }

    public function markAsRead(string $id): InertiaResponse
    {
        $notification = $this->notificationStorage->load($id);

        if ($notification instanceof Notification) {
            $notification->markAsRead(date('Y-m-d\TH:i:s\Z'));
            $this->notificationStorage->save($notification);
        }

        return Inertia::render('notifications/Index', []);
    }

    public function markAllAsRead(): InertiaResponse
    {
        $user = $this->auth->currentUser();
        $ids = $this->notificationStorage->getQuery()
            ->condition('user_id', (int) $user->id())
            ->condition('read_at', null, 'IS NULL')
            ->execute();

        $now = date('Y-m-d\TH:i:s\Z');
        foreach ($ids as $id) {
            $n = $this->notificationStorage->load($id);
            if ($n instanceof Notification) {
                $n->markAsRead($now);
                $this->notificationStorage->save($n);
            }
        }

        return Inertia::render('notifications/Index', []);
    }
}
