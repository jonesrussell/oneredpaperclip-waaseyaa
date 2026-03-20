<?php

declare(strict_types=1);

namespace OneRedPaperclip\Tests\Unit\Http;

use OneRedPaperclip\Http\Controller\PageController;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use Waaseyaa\Inertia\Inertia;
use Waaseyaa\Inertia\InertiaResponse;

#[CoversClass(PageController::class)]
final class ControllerTest extends TestCase
{
    protected function setUp(): void
    {
        Inertia::reset();
    }

    #[Test]
    public function homeRendersWelcomePage(): void
    {
        $controller = new PageController();
        $response = $controller->home();

        $this->assertInstanceOf(InertiaResponse::class, $response);

        $page = $response->toPageObject();
        $this->assertSame('Welcome', $page['component']);
    }

    #[Test]
    public function aboutRendersAboutPage(): void
    {
        $controller = new PageController();
        $response = $controller->about();

        $page = $response->toPageObject();
        $this->assertSame('About', $page['component']);
    }
}
