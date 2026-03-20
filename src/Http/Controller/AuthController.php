<?php

declare(strict_types=1);

namespace OneRedPaperclip\Http\Controller;

use OneRedPaperclip\Auth\AuthService;
use Waaseyaa\Inertia\Inertia;
use Waaseyaa\Inertia\InertiaResponse;

final class AuthController
{
    public function __construct(
        private readonly AuthService $auth,
    ) {}

    public function showLogin(): InertiaResponse
    {
        return Inertia::render('auth/Login', [
            'canResetPassword' => true,
            'status' => $_SESSION['flash_status'] ?? null,
        ]);
    }

    /**
     * @param array<string, mixed> $data
     * @return InertiaResponse|never
     */
    public function login(array $data): InertiaResponse
    {
        $email = $data['email'] ?? '';
        $password = $data['password'] ?? '';

        if ($this->auth->attempt($email, $password)) {
            session_regenerate_id(true);
            header('Location: /dashboard');
            exit;
        }

        return Inertia::render('auth/Login', [
            'canResetPassword' => true,
            'errors' => ['email' => ['These credentials do not match our records.']],
        ]);
    }

    public function showRegister(): InertiaResponse
    {
        return Inertia::render('auth/Register', []);
    }

    /**
     * @param array<string, mixed> $data
     * @return InertiaResponse|never
     */
    public function register(array $data): InertiaResponse
    {
        $errors = [];

        if (empty($data['name'])) {
            $errors['name'] = ['Name is required.'];
        }
        if (empty($data['email'])) {
            $errors['email'] = ['Email is required.'];
        }
        if (empty($data['password'])) {
            $errors['password'] = ['Password is required.'];
        }
        if (($data['password'] ?? '') !== ($data['password_confirmation'] ?? '')) {
            $errors['password'] = ['Passwords do not match.'];
        }

        if ($this->auth->findByEmail($data['email'] ?? '')) {
            $errors['email'] = ['This email is already registered.'];
        }

        if ($errors !== []) {
            return Inertia::render('auth/Register', ['errors' => $errors]);
        }

        $user = $this->auth->register([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => $data['password'],
        ]);

        $this->auth->login($user);
        session_regenerate_id(true);
        header('Location: /dashboard');
        exit;
    }

    /** @return never */
    public function logout(): void
    {
        $this->auth->logout();
        session_regenerate_id(true);
        header('Location: /');
        exit;
    }
}
