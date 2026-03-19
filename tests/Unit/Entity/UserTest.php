<?php

declare(strict_types=1);

namespace OneRedPaperclip\Tests\Unit\Entity;

use OneRedPaperclip\Entity\User;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

#[CoversClass(User::class)]
final class UserTest extends TestCase
{
    #[Test]
    public function entityTypeIdIsUser(): void
    {
        $user = new User(['name' => 'Test', 'email' => 'test@example.com', 'password' => 'hashed']);

        $this->assertSame('user', $user->getEntityTypeId());
    }

    #[Test]
    public function labelReturnsName(): void
    {
        $user = new User(['name' => 'Russell Jones']);

        $this->assertSame('Russell Jones', $user->label());
    }

    #[Test]
    public function getNameReturnsName(): void
    {
        $user = new User(['name' => 'Alice']);

        $this->assertSame('Alice', $user->getName());
    }

    #[Test]
    public function setNameUpdatesName(): void
    {
        $user = new User(['name' => 'Old']);
        $user->setName('New');

        $this->assertSame('New', $user->getName());
    }

    #[Test]
    public function getEmailReturnsEmail(): void
    {
        $user = new User(['name' => 'Test', 'email' => 'alice@example.com']);

        $this->assertSame('alice@example.com', $user->getEmail());
    }

    #[Test]
    public function setEmailUpdatesEmail(): void
    {
        $user = new User(['name' => 'Test', 'email' => 'old@example.com']);
        $user->setEmail('new@example.com');

        $this->assertSame('new@example.com', $user->getEmail());
    }

    #[Test]
    public function getPasswordReturnsPassword(): void
    {
        $user = new User(['name' => 'Test', 'password' => '$2y$10$hashed']);

        $this->assertSame('$2y$10$hashed', $user->getPassword());
    }

    #[Test]
    public function defaultIsAdminIsFalse(): void
    {
        $user = new User(['name' => 'Test']);

        $this->assertFalse($user->isAdmin());
    }

    #[Test]
    public function setAdminUpdatesFlag(): void
    {
        $user = new User(['name' => 'Test']);
        $user->setAdmin(true);

        $this->assertTrue($user->isAdmin());
    }

    #[Test]
    public function defaultXpIsZero(): void
    {
        $user = new User(['name' => 'Test']);

        $this->assertSame(0, $user->getXp());
    }

    #[Test]
    public function defaultLevelIsOne(): void
    {
        $user = new User(['name' => 'Test']);

        $this->assertSame(1, $user->getLevel());
    }

    #[Test]
    public function setXpUpdatesXp(): void
    {
        $user = new User(['name' => 'Test']);
        $user->setXp(500);

        $this->assertSame(500, $user->getXp());
    }

    #[Test]
    public function setLevelUpdatesLevel(): void
    {
        $user = new User(['name' => 'Test']);
        $user->setLevel(5);

        $this->assertSame(5, $user->getLevel());
    }

    #[Test]
    public function defaultStreaksAreZero(): void
    {
        $user = new User(['name' => 'Test']);

        $this->assertSame(0, $user->getCurrentStreak());
        $this->assertSame(0, $user->getLongestStreak());
    }

    #[Test]
    public function emailVerifiedAtIsNullByDefault(): void
    {
        $user = new User(['name' => 'Test']);

        $this->assertNull($user->getEmailVerifiedAt());
        $this->assertFalse($user->isEmailVerified());
    }

    #[Test]
    public function getNotificationPreferencesReturnsArray(): void
    {
        $user = new User(['name' => 'Test', 'notification_preferences' => json_encode(['email' => true])]);

        $this->assertSame(['email' => true], $user->getNotificationPreferences());
    }

    #[Test]
    public function getNotificationPreferencesReturnsEmptyByDefault(): void
    {
        $user = new User(['name' => 'Test']);

        $this->assertSame([], $user->getNotificationPreferences());
    }
}
