<?php

declare(strict_types=1);

namespace OneRedPaperclip\Entity;

use Waaseyaa\Entity\ContentEntityBase;

final class User extends ContentEntityBase
{
    protected string $entityTypeId = 'user';

    protected array $entityKeys = [
        'id' => 'id',
        'uuid' => 'uuid',
        'label' => 'name',
    ];

    /** @param array<string, mixed> $values */
    public function __construct(array $values = [])
    {
        if (!array_key_exists('is_admin', $values)) {
            $values['is_admin'] = 0;
        }
        if (!array_key_exists('xp', $values)) {
            $values['xp'] = 0;
        }
        if (!array_key_exists('level', $values)) {
            $values['level'] = 1;
        }
        if (!array_key_exists('current_streak', $values)) {
            $values['current_streak'] = 0;
        }
        if (!array_key_exists('longest_streak', $values)) {
            $values['longest_streak'] = 0;
        }

        parent::__construct($values, $this->entityTypeId, $this->entityKeys);
    }

    public function getName(): string
    {
        return (string) ($this->get('name') ?? '');
    }

    public function setName(string $name): static
    {
        $this->set('name', $name);

        return $this;
    }

    public function getEmail(): string
    {
        return (string) ($this->get('email') ?? '');
    }

    public function setEmail(string $email): static
    {
        $this->set('email', $email);

        return $this;
    }

    public function getPassword(): string
    {
        return (string) ($this->get('password') ?? '');
    }

    public function setPassword(string $hashedPassword): static
    {
        $this->set('password', $hashedPassword);

        return $this;
    }

    public function getProfilePhotoPath(): ?string
    {
        return $this->get('profile_photo_path');
    }

    public function isAdmin(): bool
    {
        return (bool) ($this->get('is_admin') ?? false);
    }

    public function setAdmin(bool $isAdmin): static
    {
        $this->set('is_admin', $isAdmin ? 1 : 0);

        return $this;
    }

    public function getXp(): int
    {
        return (int) ($this->get('xp') ?? 0);
    }

    public function setXp(int $xp): static
    {
        $this->set('xp', $xp);

        return $this;
    }

    public function getLevel(): int
    {
        return (int) ($this->get('level') ?? 1);
    }

    public function setLevel(int $level): static
    {
        $this->set('level', $level);

        return $this;
    }

    public function getCurrentStreak(): int
    {
        return (int) ($this->get('current_streak') ?? 0);
    }

    public function getLongestStreak(): int
    {
        return (int) ($this->get('longest_streak') ?? 0);
    }

    public function getLastActivityAt(): ?string
    {
        return $this->get('last_activity_at');
    }

    public function getEmailVerifiedAt(): ?string
    {
        return $this->get('email_verified_at');
    }

    public function isEmailVerified(): bool
    {
        return $this->getEmailVerifiedAt() !== null;
    }

    /** @return array<string, mixed> */
    public function getNotificationPreferences(): array
    {
        $prefs = $this->get('notification_preferences');

        if (\is_array($prefs)) {
            return $prefs;
        }

        if (\is_string($prefs)) {
            return json_decode($prefs, true) ?? [];
        }

        return [];
    }

    public function getCreatedAt(): ?string
    {
        return $this->get('created_at');
    }

    public function getUpdatedAt(): ?string
    {
        return $this->get('updated_at');
    }
}
