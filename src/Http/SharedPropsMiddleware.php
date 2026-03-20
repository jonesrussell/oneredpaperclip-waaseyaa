<?php

declare(strict_types=1);

namespace OneRedPaperclip\Http;

use OneRedPaperclip\Auth\AuthService;
use Waaseyaa\Inertia\Inertia;

/**
 * Shares common props with all Inertia responses.
 *
 * Equivalent to Laravel's HandleInertiaRequests middleware —
 * shares auth.user, flash messages, and app metadata.
 */
final class SharedPropsMiddleware
{
    public function __construct(
        private readonly AuthService $auth,
        private readonly string $appName = 'One Red Paperclip',
    ) {}

    public function share(): void
    {
        $user = $this->auth->currentUser();

        Inertia::share('auth', [
            'user' => $user !== null ? [
                'id' => $user->id(),
                'name' => $user->getName(),
                'email' => $user->getEmail(),
                'is_admin' => $user->isAdmin(),
                'xp' => $user->getXp(),
                'level' => $user->getLevel(),
                'current_streak' => $user->getCurrentStreak(),
                'profile_photo_path' => $user->getProfilePhotoPath(),
            ] : null,
        ]);

        Inertia::share('name', $this->appName);
        Inertia::share('flash', [
            'success' => $_SESSION['flash_success'] ?? null,
            'error' => $_SESSION['flash_error'] ?? null,
        ]);

        // Clear flash after sharing.
        unset($_SESSION['flash_success'], $_SESSION['flash_error']);
    }
}
