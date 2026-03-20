<?php

declare(strict_types=1);

namespace OneRedPaperclip\Tests\Unit\Auth;

use OneRedPaperclip\Auth\AccountAdapter;
use OneRedPaperclip\Entity\User;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

#[CoversClass(AccountAdapter::class)]
final class AccountAdapterTest extends TestCase
{
    #[Test]
    public function idReturnsUserId(): void
    {
        $user = new User(['id' => 42, 'name' => 'Test']);
        $account = new AccountAdapter($user);

        $this->assertSame(42, $account->id());
    }

    #[Test]
    public function isAuthenticatedReturnsTrue(): void
    {
        $user = new User(['name' => 'Test']);
        $account = new AccountAdapter($user);

        $this->assertTrue($account->isAuthenticated());
    }

    #[Test]
    public function adminHasAllPermissions(): void
    {
        $user = new User(['name' => 'Admin', 'is_admin' => 1]);
        $account = new AccountAdapter($user);

        $this->assertTrue($account->hasPermission('anything'));
        $this->assertTrue($account->hasPermission('administer users'));
    }

    #[Test]
    public function regularUserHasNoPermissions(): void
    {
        $user = new User(['name' => 'Regular']);
        $account = new AccountAdapter($user);

        $this->assertFalse($account->hasPermission('anything'));
    }

    #[Test]
    public function adminHasAdminRole(): void
    {
        $user = new User(['name' => 'Admin', 'is_admin' => 1]);
        $account = new AccountAdapter($user);

        $this->assertContains('admin', $account->getRoles());
        $this->assertContains('authenticated', $account->getRoles());
    }

    #[Test]
    public function regularUserHasAuthenticatedRole(): void
    {
        $user = new User(['name' => 'Regular']);
        $account = new AccountAdapter($user);

        $this->assertSame(['authenticated'], $account->getRoles());
    }

    #[Test]
    public function getUserReturnsWrappedUser(): void
    {
        $user = new User(['name' => 'Test']);
        $account = new AccountAdapter($user);

        $this->assertSame($user, $account->getUser());
    }
}
