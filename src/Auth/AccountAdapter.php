<?php

declare(strict_types=1);

namespace OneRedPaperclip\Auth;

use OneRedPaperclip\Entity\User;
use Waaseyaa\Access\AccountInterface;

/**
 * Adapts our User entity to the framework's AccountInterface.
 */
final class AccountAdapter implements AccountInterface
{
    public function __construct(
        private readonly User $user,
    ) {}

    public function id(): int|string
    {
        return (int) $this->user->id();
    }

    public function hasPermission(string $permission): bool
    {
        if ($this->user->isAdmin()) {
            return true;
        }

        return false;
    }

    /** @return list<string> */
    public function getRoles(): array
    {
        $roles = ['authenticated'];

        if ($this->user->isAdmin()) {
            $roles[] = 'admin';
        }

        return $roles;
    }

    public function isAuthenticated(): bool
    {
        return true;
    }

    public function getUser(): User
    {
        return $this->user;
    }
}
