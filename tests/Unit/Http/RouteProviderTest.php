<?php

declare(strict_types=1);

namespace OneRedPaperclip\Tests\Unit\Http;

use OneRedPaperclip\Http\RouteProvider;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use Waaseyaa\Routing\WaaseyaaRouter;

#[CoversClass(RouteProvider::class)]
final class RouteProviderTest extends TestCase
{
    private WaaseyaaRouter $router;

    protected function setUp(): void
    {
        $this->router = new WaaseyaaRouter();
        $provider = new RouteProvider();
        $provider->register($this->router);
    }

    /**
     * @return array<string, array{string}>
     */
    public static function routeNameProvider(): array
    {
        return [
            'home' => ['home'],
            'about' => ['about'],
            'challenges.index' => ['challenges.index'],
            'challenges.show' => ['challenges.show'],
            'challenges.create' => ['challenges.create'],
            'challenges.store' => ['challenges.store'],
            'challenges.edit' => ['challenges.edit'],
            'challenges.update' => ['challenges.update'],
            'challenges.ai-suggest' => ['challenges.ai-suggest'],
            'challenges.offers.store' => ['challenges.offers.store'],
            'offers.accept' => ['offers.accept'],
            'offers.decline' => ['offers.decline'],
            'trades.update' => ['trades.update'],
            'trades.confirm' => ['trades.confirm'],
            'notifications.index' => ['notifications.index'],
            'notifications.unread-count' => ['notifications.unread-count'],
            'notifications.mark-read' => ['notifications.mark-read'],
            'notifications.mark-all-read' => ['notifications.mark-all-read'],
            'api.challenges.index' => ['api.challenges.index'],
            'api.challenges.show' => ['api.challenges.show'],
            'api.challenges.store' => ['api.challenges.store'],
            'api.offers.store' => ['api.offers.store'],
            'api.offers.accept' => ['api.offers.accept'],
            'api.offers.decline' => ['api.offers.decline'],
            'api.trades.confirm' => ['api.trades.confirm'],
        ];
    }

    #[Test]
    #[DataProvider('routeNameProvider')]
    public function routeIsRegistered(string $routeName): void
    {
        $routes = $this->router->getRouteCollection();

        $this->assertNotNull($routes->get($routeName), "Route '{$routeName}' is not registered");
    }

    #[Test]
    public function registersTwentyFiveRoutes(): void
    {
        $routes = $this->router->getRouteCollection();

        $this->assertCount(25, $routes);
    }

    #[Test]
    public function homeRouteMatchesSlash(): void
    {
        $match = $this->router->match('/');

        $this->assertSame('home', $match['_route']);
    }

    #[Test]
    public function challengesIndexRouteMatches(): void
    {
        $match = $this->router->match('/challenges');

        $this->assertSame('challenges.index', $match['_route']);
    }

    #[Test]
    public function challengeShowRouteMatchesSlug(): void
    {
        $match = $this->router->match('/challenges/red-paperclip');

        $this->assertSame('challenges.show', $match['_route']);
        $this->assertSame('red-paperclip', $match['challenge']);
    }

    #[Test]
    public function apiChallengesRouteMatches(): void
    {
        $match = $this->router->match('/api/challenges');

        $this->assertSame('api.challenges.index', $match['_route']);
    }

    #[Test]
    public function publicRoutesDoNotRequireAuth(): void
    {
        $routes = $this->router->getRouteCollection();

        $home = $routes->get('home');
        $this->assertTrue($home->getOption('_public') ?? false);

        $index = $routes->get('challenges.index');
        $this->assertTrue($index->getOption('_public') ?? false);
    }

    #[Test]
    public function protectedRoutesRequireAuth(): void
    {
        $routes = $this->router->getRouteCollection();

        $create = $routes->get('challenges.create');
        $this->assertTrue($create->getOption('_authenticated') ?? false);

        $store = $routes->get('challenges.store');
        $this->assertTrue($store->getOption('_authenticated') ?? false);
    }

    #[Test]
    public function canGenerateChallengeShowUrl(): void
    {
        $url = $this->router->generate('challenges.show', ['challenge' => 'red-paperclip']);

        $this->assertSame('/challenges/red-paperclip', $url);
    }
}
