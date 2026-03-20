<?php

declare(strict_types=1);

namespace OneRedPaperclip\Auth;

use OneRedPaperclip\Entity\User;
use Waaseyaa\EntityStorage\SqlEntityStorage;

/**
 * Authentication service for One Red Paperclip.
 *
 * Bridges our User entity with session-based authentication.
 * Uses password_hash/password_verify for bcrypt password checking.
 */
final class AuthService
{
    private ?User $currentUser = null;

    public function __construct(
        private readonly SqlEntityStorage $userStorage,
    ) {}

    /**
     * Attempt login with email and password.
     */
    public function attempt(string $email, string $password): bool
    {
        $user = $this->findByEmail($email);

        if ($user === null) {
            return false;
        }

        if (!password_verify($password, $user->getPassword())) {
            return false;
        }

        $this->login($user);

        return true;
    }

    public function login(User $user): void
    {
        $this->currentUser = $user;
        $_SESSION['waaseyaa_uid'] = $user->id();
    }

    public function logout(): void
    {
        $this->currentUser = null;
        unset($_SESSION['waaseyaa_uid']);
    }

    public function isAuthenticated(): bool
    {
        return $this->currentUser() !== null;
    }

    public function currentUser(): ?User
    {
        if ($this->currentUser !== null) {
            return $this->currentUser;
        }

        if (!isset($_SESSION['waaseyaa_uid']) || $_SESSION['waaseyaa_uid'] === '') {
            return null;
        }

        $user = $this->userStorage->load($_SESSION['waaseyaa_uid']);

        if ($user instanceof User) {
            $this->currentUser = $user;

            return $user;
        }

        return null;
    }

    public function currentAccount(): ?AccountAdapter
    {
        $user = $this->currentUser();

        return $user !== null ? new AccountAdapter($user) : null;
    }

    /**
     * Find a user by email address.
     */
    public function findByEmail(string $email): ?User
    {
        $ids = $this->userStorage->getQuery()
            ->condition('email', $email)
            ->execute();

        if ($ids === []) {
            return null;
        }

        $id = reset($ids);

        $user = $this->userStorage->load($id);

        return $user instanceof User ? $user : null;
    }

    /**
     * Register a new user.
     *
     * @param array{name: string, email: string, password: string} $data
     */
    public function register(array $data): User
    {
        $user = new User([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => password_hash($data['password'], \PASSWORD_BCRYPT),
        ]);

        $this->userStorage->save($user);

        return $user;
    }
}
