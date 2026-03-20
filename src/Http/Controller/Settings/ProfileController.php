<?php

declare(strict_types=1);

namespace OneRedPaperclip\Http\Controller\Settings;

use OneRedPaperclip\Auth\AuthService;
use Waaseyaa\EntityStorage\SqlEntityStorage;
use Waaseyaa\Inertia\Inertia;
use Waaseyaa\Inertia\InertiaResponse;

final class ProfileController
{
    public function __construct(
        private readonly SqlEntityStorage $userStorage,
        private readonly AuthService $auth,
    ) {}

    public function edit(): InertiaResponse
    {
        return Inertia::render('settings/Profile', []);
    }

    /**
     * @param array<string, mixed> $data
     */
    public function update(array $data): InertiaResponse
    {
        $user = $this->auth->currentUser();

        if (isset($data['name'])) {
            $user->setName($data['name']);
        }
        if (isset($data['email'])) {
            $user->setEmail($data['email']);
        }

        $this->userStorage->save($user);

        return Inertia::render('settings/Profile', []);
    }
}
