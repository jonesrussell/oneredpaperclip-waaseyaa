<?php

declare(strict_types=1);

namespace OneRedPaperclip\Http;

use Waaseyaa\Routing\RouteBuilder;
use Waaseyaa\Routing\WaaseyaaRouter;

final class RouteProvider
{
    public function register(WaaseyaaRouter $router): void
    {
        $this->authRoutes($router);
        $this->publicRoutes($router);
        $this->dashboardRoutes($router);
        $this->challengeRoutes($router);
        $this->offerRoutes($router);
        $this->tradeRoutes($router);
        $this->notificationRoutes($router);
        $this->apiRoutes($router);
    }

    private function authRoutes(WaaseyaaRouter $router): void
    {
        $router->addRoute('login', RouteBuilder::create('/login')
            ->controller('OneRedPaperclip\Http\Controller\AuthController::showLogin')
            ->methods('GET')
            ->allowAll()
            ->build());

        $router->addRoute('login.store', RouteBuilder::create('/login')
            ->controller('OneRedPaperclip\Http\Controller\AuthController::login')
            ->methods('POST')
            ->allowAll()
            ->build());

        $router->addRoute('register', RouteBuilder::create('/register')
            ->controller('OneRedPaperclip\Http\Controller\AuthController::showRegister')
            ->methods('GET')
            ->allowAll()
            ->build());

        $router->addRoute('register.store', RouteBuilder::create('/register')
            ->controller('OneRedPaperclip\Http\Controller\AuthController::register')
            ->methods('POST')
            ->allowAll()
            ->build());

        $router->addRoute('logout', RouteBuilder::create('/logout')
            ->controller('OneRedPaperclip\Http\Controller\AuthController::logout')
            ->methods('POST')
            ->requireAuthentication()
            ->build());
    }

    private function dashboardRoutes(WaaseyaaRouter $router): void
    {
        $router->addRoute('dashboard', RouteBuilder::create('/dashboard')
            ->controller('OneRedPaperclip\Http\Controller\DashboardController::__invoke')
            ->methods('GET')
            ->requireAuthentication()
            ->build());

        $router->addRoute('admin.challenges.index', RouteBuilder::create('/dashboard/admin/challenges')
            ->controller('OneRedPaperclip\Http\Controller\Admin\AdminChallengeController::index')
            ->methods('GET')
            ->requireAuthentication()
            ->build());

        $router->addRoute('admin.challenges.show', RouteBuilder::create('/dashboard/admin/challenges/{id}')
            ->controller('OneRedPaperclip\Http\Controller\Admin\AdminChallengeController::show')
            ->methods('GET')
            ->requireAuthentication()
            ->build());
    }

    private function publicRoutes(WaaseyaaRouter $router): void
    {
        $router->addRoute('home', RouteBuilder::create('/')
            ->controller('OneRedPaperclip\Http\Controller\PageController::home')
            ->methods('GET')
            ->allowAll()
            ->build());

        $router->addRoute('about', RouteBuilder::create('/about')
            ->controller('OneRedPaperclip\Http\Controller\PageController::about')
            ->methods('GET')
            ->allowAll()
            ->build());

        $router->addRoute('challenges.index', RouteBuilder::create('/challenges')
            ->controller('OneRedPaperclip\Http\Controller\ChallengeController::index')
            ->methods('GET')
            ->allowAll()
            ->build());

        $router->addRoute('challenges.show', RouteBuilder::create('/challenges/{challenge}')
            ->controller('OneRedPaperclip\Http\Controller\ChallengeController::show')
            ->methods('GET')
            ->allowAll()
            ->requirement('challenge', '[a-z0-9-]+')
            ->build());
    }

    private function challengeRoutes(WaaseyaaRouter $router): void
    {
        $router->addRoute('challenges.create', RouteBuilder::create('/challenges/create')
            ->controller('OneRedPaperclip\Http\Controller\ChallengeController::create')
            ->methods('GET')
            ->requireAuthentication()
            ->build());

        $router->addRoute('challenges.store', RouteBuilder::create('/challenges')
            ->controller('OneRedPaperclip\Http\Controller\ChallengeController::store')
            ->methods('POST')
            ->requireAuthentication()
            ->build());

        $router->addRoute('challenges.edit', RouteBuilder::create('/challenges/{challenge}/edit')
            ->controller('OneRedPaperclip\Http\Controller\ChallengeController::edit')
            ->methods('GET')
            ->requireAuthentication()
            ->requirement('challenge', '[a-z0-9-]+')
            ->build());

        $router->addRoute('challenges.update', RouteBuilder::create('/challenges/{challenge}')
            ->controller('OneRedPaperclip\Http\Controller\ChallengeController::update')
            ->methods('PUT')
            ->requireAuthentication()
            ->requirement('challenge', '[a-z0-9-]+')
            ->build());

        $router->addRoute('challenges.ai-suggest', RouteBuilder::create('/challenges/ai-suggest')
            ->controller('OneRedPaperclip\Http\Controller\ChallengeController::aiSuggest')
            ->methods('POST')
            ->requireAuthentication()
            ->build());
    }

    private function offerRoutes(WaaseyaaRouter $router): void
    {
        $router->addRoute('challenges.offers.store', RouteBuilder::create('/challenges/{challenge}/offers')
            ->controller('OneRedPaperclip\Http\Controller\OfferController::store')
            ->methods('POST')
            ->requireAuthentication()
            ->build());

        $router->addRoute('offers.accept', RouteBuilder::create('/offers/{offer}/accept')
            ->controller('OneRedPaperclip\Http\Controller\OfferController::accept')
            ->methods('POST')
            ->requireAuthentication()
            ->build());

        $router->addRoute('offers.decline', RouteBuilder::create('/offers/{offer}/decline')
            ->controller('OneRedPaperclip\Http\Controller\OfferController::decline')
            ->methods('POST')
            ->requireAuthentication()
            ->build());
    }

    private function tradeRoutes(WaaseyaaRouter $router): void
    {
        $router->addRoute('trades.update', RouteBuilder::create('/trades/{trade}')
            ->controller('OneRedPaperclip\Http\Controller\TradeController::update')
            ->methods('PATCH')
            ->requireAuthentication()
            ->build());

        $router->addRoute('trades.confirm', RouteBuilder::create('/trades/{trade}/confirm')
            ->controller('OneRedPaperclip\Http\Controller\TradeController::confirm')
            ->methods('POST')
            ->requireAuthentication()
            ->build());
    }

    private function notificationRoutes(WaaseyaaRouter $router): void
    {
        $router->addRoute('notifications.index', RouteBuilder::create('/notifications')
            ->controller('OneRedPaperclip\Http\Controller\NotificationController::index')
            ->methods('GET')
            ->requireAuthentication()
            ->build());

        $router->addRoute('notifications.unread-count', RouteBuilder::create('/notifications/unread-count')
            ->controller('OneRedPaperclip\Http\Controller\NotificationController::unreadCount')
            ->methods('GET')
            ->requireAuthentication()
            ->build());

        $router->addRoute('notifications.mark-read', RouteBuilder::create('/notifications/{id}/read')
            ->controller('OneRedPaperclip\Http\Controller\NotificationController::markAsRead')
            ->methods('POST')
            ->requireAuthentication()
            ->build());

        $router->addRoute('notifications.mark-all-read', RouteBuilder::create('/notifications/mark-all-read')
            ->controller('OneRedPaperclip\Http\Controller\NotificationController::markAllAsRead')
            ->methods('POST')
            ->requireAuthentication()
            ->build());
    }

    private function apiRoutes(WaaseyaaRouter $router): void
    {
        $router->addRoute('api.challenges.index', RouteBuilder::create('/api/challenges')
            ->controller('OneRedPaperclip\Http\Controller\Api\ChallengeApiController::index')
            ->methods('GET')
            ->allowAll()
            ->jsonApi()
            ->build());

        $router->addRoute('api.challenges.show', RouteBuilder::create('/api/challenges/{challenge}')
            ->controller('OneRedPaperclip\Http\Controller\Api\ChallengeApiController::show')
            ->methods('GET')
            ->allowAll()
            ->jsonApi()
            ->build());

        $router->addRoute('api.challenges.store', RouteBuilder::create('/api/challenges')
            ->controller('OneRedPaperclip\Http\Controller\Api\ChallengeApiController::store')
            ->methods('POST')
            ->requireAuthentication()
            ->jsonApi()
            ->build());

        $router->addRoute('api.offers.store', RouteBuilder::create('/api/challenges/{challenge}/offers')
            ->controller('OneRedPaperclip\Http\Controller\Api\OfferApiController::store')
            ->methods('POST')
            ->requireAuthentication()
            ->jsonApi()
            ->build());

        $router->addRoute('api.offers.accept', RouteBuilder::create('/api/offers/{offer}/accept')
            ->controller('OneRedPaperclip\Http\Controller\Api\OfferApiController::accept')
            ->methods('POST')
            ->requireAuthentication()
            ->jsonApi()
            ->build());

        $router->addRoute('api.offers.decline', RouteBuilder::create('/api/offers/{offer}/decline')
            ->controller('OneRedPaperclip\Http\Controller\Api\OfferApiController::decline')
            ->methods('POST')
            ->requireAuthentication()
            ->jsonApi()
            ->build());

        $router->addRoute('api.trades.confirm', RouteBuilder::create('/api/trades/{trade}/confirm')
            ->controller('OneRedPaperclip\Http\Controller\Api\TradeApiController::confirm')
            ->methods('POST')
            ->requireAuthentication()
            ->jsonApi()
            ->build());
    }
}
