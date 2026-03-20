<?php

declare(strict_types=1);

namespace OneRedPaperclip\Tests\Unit\Auth;

use OneRedPaperclip\Auth\AuthService;
use OneRedPaperclip\Entity\User;
use OneRedPaperclip\Schema\SchemaInstaller;
use OneRedPaperclip\TradeUpServiceProvider;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use Psr\EventDispatcher\EventDispatcherInterface;
use Waaseyaa\Database\DBALDatabase;
use Waaseyaa\EntityStorage\EntityStorageFactory;
use Waaseyaa\EntityStorage\SqlEntityStorage;

#[CoversClass(AuthService::class)]
final class AuthServiceTest extends TestCase
{
    private AuthService $auth;
    private SqlEntityStorage $userStorage;

    protected function setUp(): void
    {
        // Start a clean session for each test.
        $_SESSION = [];

        $database = DBALDatabase::createSqlite();
        $provider = new TradeUpServiceProvider();
        $provider->register();

        (new SchemaInstaller($database, $provider->getEntityTypes()))->install();

        $dispatcher = new class implements EventDispatcherInterface {
            public function dispatch(object $event): object
            {
                return $event;
            }
        };

        $factory = new EntityStorageFactory($database, $dispatcher);
        $entityTypes = [];
        foreach ($provider->getEntityTypes() as $type) {
            $entityTypes[$type->id()] = $type;
        }

        $this->userStorage = $factory->getStorage($entityTypes['user']);
        $this->auth = new AuthService($this->userStorage);
    }

    protected function tearDown(): void
    {
        $_SESSION = [];
    }

    #[Test]
    public function registerCreatesUser(): void
    {
        $user = $this->auth->register([
            'name' => 'Alice',
            'email' => 'alice@example.com',
            'password' => 'secret123',
        ]);

        $this->assertInstanceOf(User::class, $user);
        $this->assertSame('Alice', $user->getName());
        $this->assertSame('alice@example.com', $user->getEmail());
        $this->assertNotEmpty($user->id());
    }

    #[Test]
    public function registerHashesPassword(): void
    {
        $user = $this->auth->register([
            'name' => 'Alice',
            'email' => 'alice@example.com',
            'password' => 'secret123',
        ]);

        $this->assertNotSame('secret123', $user->getPassword());
        $this->assertTrue(password_verify('secret123', $user->getPassword()));
    }

    #[Test]
    public function attemptSucceedsWithCorrectCredentials(): void
    {
        $this->auth->register([
            'name' => 'Alice',
            'email' => 'alice@example.com',
            'password' => 'secret123',
        ]);

        $this->assertTrue($this->auth->attempt('alice@example.com', 'secret123'));
        $this->assertTrue($this->auth->isAuthenticated());
    }

    #[Test]
    public function attemptFailsWithWrongPassword(): void
    {
        $this->auth->register([
            'name' => 'Alice',
            'email' => 'alice@example.com',
            'password' => 'secret123',
        ]);

        $this->assertFalse($this->auth->attempt('alice@example.com', 'wrong'));
        $this->assertFalse($this->auth->isAuthenticated());
    }

    #[Test]
    public function attemptFailsWithUnknownEmail(): void
    {
        $this->assertFalse($this->auth->attempt('nobody@example.com', 'secret'));
    }

    #[Test]
    public function currentUserReturnsNullWhenNotAuthenticated(): void
    {
        $this->assertNull($this->auth->currentUser());
    }

    #[Test]
    public function currentUserReturnsUserAfterLogin(): void
    {
        $user = $this->auth->register([
            'name' => 'Alice',
            'email' => 'alice@example.com',
            'password' => 'secret123',
        ]);

        $this->auth->login($user);

        $this->assertSame('Alice', $this->auth->currentUser()->getName());
    }

    #[Test]
    public function logoutClearsSession(): void
    {
        $user = $this->auth->register([
            'name' => 'Alice',
            'email' => 'alice@example.com',
            'password' => 'secret123',
        ]);

        $this->auth->login($user);
        $this->assertTrue($this->auth->isAuthenticated());

        $this->auth->logout();
        $this->assertFalse($this->auth->isAuthenticated());
        $this->assertNull($this->auth->currentUser());
    }

    #[Test]
    public function currentAccountReturnsAdapterWhenAuthenticated(): void
    {
        $user = $this->auth->register([
            'name' => 'Alice',
            'email' => 'alice@example.com',
            'password' => 'secret123',
        ]);

        $this->auth->login($user);

        $account = $this->auth->currentAccount();
        $this->assertNotNull($account);
        $this->assertTrue($account->isAuthenticated());
        $this->assertSame((int) $user->id(), $account->id());
    }

    #[Test]
    public function currentAccountReturnsNullWhenNotAuthenticated(): void
    {
        $this->assertNull($this->auth->currentAccount());
    }

    #[Test]
    public function findByEmailReturnsUser(): void
    {
        $this->auth->register([
            'name' => 'Alice',
            'email' => 'alice@example.com',
            'password' => 'secret123',
        ]);

        $found = $this->auth->findByEmail('alice@example.com');

        $this->assertInstanceOf(User::class, $found);
        $this->assertSame('Alice', $found->getName());
    }

    #[Test]
    public function findByEmailReturnsNullForUnknown(): void
    {
        $this->assertNull($this->auth->findByEmail('nobody@example.com'));
    }
}
