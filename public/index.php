<?php

declare(strict_types=1);

/**
 * One Red Paperclip — Waaseyaa HTTP Entry Point
 *
 * Bootstraps the application, resolves the route, and dispatches
 * the request to the appropriate controller.
 */

require_once __DIR__ . '/../vendor/autoload.php';

use OneRedPaperclip\Auth\AuthService;
use OneRedPaperclip\Http\RouteProvider;
use OneRedPaperclip\Http\SharedPropsMiddleware;
use OneRedPaperclip\Schema\SchemaInstaller;
use OneRedPaperclip\TradeUpServiceProvider;
use Psr\EventDispatcher\EventDispatcherInterface;
use Waaseyaa\Database\DBALDatabase;
use Waaseyaa\EntityStorage\EntityStorageFactory;
use Waaseyaa\Inertia\Inertia;
use Waaseyaa\Routing\WaaseyaaRouter;

// Load environment.
$dotenv = __DIR__ . '/../.env';
$env = [];
if (file_exists($dotenv)) {
    foreach (file($dotenv, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES) as $line) {
        if ($line[0] === '#') {
            continue;
        }
        [$key, $value] = explode('=', $line, 2) + [1 => ''];
        $env[trim($key)] = trim($value, '"\'');
    }
}

// Database connection.
$dbPath = $env['DB_DATABASE'] ?? __DIR__ . '/../database/database.sqlite';
$database = DBALDatabase::createSqlite($dbPath);

// Session.
session_start();

// Boot entity types.
$provider = new TradeUpServiceProvider();
$provider->register();

// Ensure schema.
$installer = new SchemaInstaller($database, $provider->getEntityTypes());
$installer->install();

// Storage factory.
$dispatcher = new class implements EventDispatcherInterface {
    public function dispatch(object $event): object
    {
        return $event;
    }
};
$storageFactory = new EntityStorageFactory($database, $dispatcher);
$entityTypes = [];
foreach ($provider->getEntityTypes() as $type) {
    $entityTypes[$type->id()] = $type;
}

// Auth service.
$authService = new AuthService($storageFactory->getStorage($entityTypes['user']));

// Inertia setup.
$appUrl = $env['APP_URL'] ?? 'http://localhost:8080';
$manifestFile = __DIR__ . '/build/.vite/manifest.json';
Inertia::setVersion(file_exists($manifestFile) ? md5_file($manifestFile) : '1');

// Shared props.
$sharedProps = new SharedPropsMiddleware($authService, $env['APP_NAME'] ?? 'One Red Paperclip');
$sharedProps->share();

// Router.
$router = new WaaseyaaRouter();
$routeProvider = new RouteProvider();
$routeProvider->register($router);

// Resolve request.
$requestUri = strtok($_SERVER['REQUEST_URI'] ?? '/', '?');
$requestMethod = $_SERVER['REQUEST_METHOD'] ?? 'GET';

try {
    $match = $router->match($requestUri);
} catch (\Symfony\Component\Routing\Exception\ResourceNotFoundException $e) {
    // Try serving as static file or return 404.
    http_response_code(404);
    if (isset($_SERVER['HTTP_X_INERTIA'])) {
        header('Content-Type: application/json');
        echo json_encode(Inertia::render('errors/NotFound', [])->toPageObject());
    } else {
        echo renderInertiaPage(Inertia::render('errors/NotFound', [])->toPageObject(), $env);
    }
    exit;
}

// Extract controller and method.
$controller = $match['_controller'] ?? null;
if ($controller === null) {
    http_response_code(500);
    echo 'No controller for route.';
    exit;
}

// Check authentication requirement.
$route = $router->getRouteCollection()->get($match['_route']);
$requiresAuth = $route?->getOption('_authenticated') ?? false;

if ($requiresAuth && !$authService->isAuthenticated()) {
    if (isset($_SERVER['HTTP_X_INERTIA'])) {
        http_response_code(409);
        header('X-Inertia-Location: /login');
    } else {
        header('Location: /login');
    }
    exit;
}

// Parse controller string "Class::method".
[$className, $methodName] = explode('::', $controller);

// Build controller with dependencies.
$controllerInstance = buildController($className, $storageFactory, $entityTypes, $authService);

// Get route parameters (exclude internal ones).
$params = array_filter($match, fn ($k) => $k[0] !== '_', ARRAY_FILTER_USE_KEY);

// Handle POST data.
$postData = [];
if (in_array($requestMethod, ['POST', 'PUT', 'PATCH', 'DELETE'])) {
    $contentType = $_SERVER['CONTENT_TYPE'] ?? '';
    if (str_contains($contentType, 'application/json')) {
        $postData = json_decode(file_get_contents('php://input'), true) ?? [];
    } else {
        $postData = $_POST;
    }
}

// Call controller method.
$args = array_values($params);
if ($postData !== []) {
    $args[] = $postData;
}

$response = $controllerInstance->$methodName(...$args);

// Send response.
if ($response instanceof \Waaseyaa\Inertia\InertiaResponse) {
    $pageObject = $response->toPageObject();
    $pageObject['url'] = $requestUri;

    if (isset($_SERVER['HTTP_X_INERTIA'])) {
        header('Content-Type: application/json');
        header('X-Inertia: true');
        echo json_encode($pageObject);
    } else {
        echo renderInertiaPage($pageObject, $env);
    }
} elseif (is_array($response)) {
    header('Content-Type: application/json');
    if (isset($response['content_type'])) {
        header('Content-Type: ' . $response['content_type']);
        echo $response['body'];
    } else {
        echo json_encode($response);
    }
}

// --- Helper functions ---

function buildController(string $class, EntityStorageFactory $factory, array $types, AuthService $auth): object
{
    return match ($class) {
        'OneRedPaperclip\Http\Controller\PageController' => new $class(),
        'OneRedPaperclip\Http\Controller\ChallengeController' => new $class(
            $factory->getStorage($types['challenge']),
            $factory->getStorage($types['item']),
            $factory->getStorage($types['category']),
            $auth,
        ),
        'OneRedPaperclip\Http\Controller\OfferController' => new $class(
            $factory->getStorage($types['offer']),
            $factory->getStorage($types['item']),
            $factory->getStorage($types['challenge']),
            $factory->getStorage($types['trade']),
            $auth,
        ),
        'OneRedPaperclip\Http\Controller\TradeController' => new $class(
            $factory->getStorage($types['trade']),
            $factory->getStorage($types['offer']),
            $factory->getStorage($types['challenge']),
            $auth,
        ),
        'OneRedPaperclip\Http\Controller\NotificationController' => new $class(
            $factory->getStorage($types['notification']),
            $auth,
        ),
        'OneRedPaperclip\Http\Controller\DashboardController' => new $class(
            $factory->getStorage($types['challenge']),
            $auth,
        ),
        'OneRedPaperclip\Http\Controller\SitemapController' => new $class(
            $factory->getStorage($types['challenge']),
            $_ENV['APP_URL'] ?? 'https://oneredpaperclip.xyz',
        ),
        'OneRedPaperclip\Http\Controller\Admin\AdminChallengeController' => new $class(
            $factory->getStorage($types['challenge']),
        ),
        'OneRedPaperclip\Http\Controller\Api\ChallengeApiController' => new $class(
            $factory->getStorage($types['challenge']),
            $auth,
        ),
        'OneRedPaperclip\Http\Controller\Settings\ProfileController' => new $class(
            $factory->getStorage($types['user']),
            $auth,
        ),
        default => new $class(),
    };
}

function renderInertiaPage(array $pageObject, array $env): string
{
    $pageJson = htmlspecialchars(json_encode($pageObject), ENT_QUOTES, 'UTF-8');
    $appName = $env['APP_NAME'] ?? 'One Red Paperclip';
    $title = $pageObject['props']['title'] ?? $appName;

    // Read asset paths from Vite manifest.
    $manifestPath = __DIR__ . '/build/.vite/manifest.json';
    $jsFile = 'assets/app.js';
    $cssFile = 'assets/app.css';

    if (file_exists($manifestPath)) {
        $manifest = json_decode(file_get_contents($manifestPath), true);
        $entry = $manifest['resources/js/app.ts'] ?? [];
        $jsFile = $entry['file'] ?? $jsFile;
        $cssFile = ($entry['css'][0] ?? $cssFile);
    }

    return <<<HTML
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{$title}</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=dm-sans:400,500,600,700|fredoka:400,500,600,700|jetbrains-mono:400,500" rel="stylesheet" />
    <link rel="stylesheet" href="/build/{$cssFile}">
</head>
<body class="font-sans antialiased">
    <div id="app" data-page='{$pageJson}'></div>
    <script type="module" src="/build/{$jsFile}"></script>
</body>
</html>
HTML;
}
