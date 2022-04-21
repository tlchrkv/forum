<?php

declare(strict_types=1);

if (getenv('APP_ENV') !== 'production') {
    error_reporting(E_ALL);
}

use Phalcon\Mvc\Application;
use Phalcon\Mvc\Router;
use Phalcon\Mvc\View\Simple;
use Phalcon\DI\FactoryDefault;
use Phalcon\Mvc\View\Engine\Volt;
use Phalcon\Session\Adapter\Files as FileSession;

require_once __DIR__ . '/../vendor/autoload.php';

$diContainer = new FactoryDefault();

$application = new Application($diContainer);
$application->useImplicitView(false);

// Session
$diContainer->setShared('session', function () {
    $session = new FileSession();
    $session->start();
    return $session;
});

// Database
$databaseConfig = include __DIR__ . '/../config/database.php';
$diContainer->set('db', function () use ($databaseConfig) {
    $adapter = 'Phalcon\Db\Adapter\Pdo\\' . $databaseConfig['adapter'];
    return new $adapter([
        'host' => $databaseConfig['host'],
        'username' => $databaseConfig['username'],
        'password' => $databaseConfig['password'],
        'dbname' => $databaseConfig['dbname'],
    ]);
});

// Router
$routes = include __DIR__ . '/../config/routes.php';
$diContainer->set('router', function () use ($routes) {
    $router = new Router();
    $router->setUriSource(Router::URI_SOURCE_SERVER_REQUEST_URI);
    $router->removeExtraSlashes(true);
    foreach ($routes as $name => $config) {
        $route = $router->add(
            $config['pattern'],
            $config['paths'] ?? null,
            $config['httpMethods'] ?? null,
            $config['position'] ?? Router::POSITION_LAST
        );
        $route->setName($name);
        if (isset($config['hostname'])) {
            $route->setHostname($config['hostname']);
        }
        if (isset($config['converts'])) {
            foreach ($config['converts'] as $id => $callback) {
                $route->convert($id, $callback);
            }
        }
    }
    return $router;
});

// Views
$diContainer->set('view', function () {
    $view = new Simple();
    $view->registerEngines([
        '.volt' => function ($view) {
            $volt = new Volt($view, $this);
            $volt->setOptions([
                'compiledPath' => __DIR__ . '/../storage/cache/views/',
                'compiledSeparator' => '_',
            ]);
            return $volt;
        },
    ]);
    $view->appName = getenv('APP_NAME');
    $view->categoryAccess = new \App\Access\Models\AccessChecker\Forum\CategoryAccessChecker();
    $view->commentAccess = new \App\Access\Models\AccessChecker\Forum\CommentAccessChecker();
    $view->topicAccess = new \App\Access\Models\AccessChecker\Forum\TopicAccessChecker();
    $view->userAccess = new \App\Access\Models\AccessChecker\User\AccessChecker();
    $view->user = (new \App\Auth\Models\Auth())->getUserFromSession();
    return $view;
});

$diContainer->setShared('config', function () {
    return include __DIR__ . '/../config/config.php';
});

try {
    $application->handle()->getContent();
} catch (\App\SharedKernel\Exceptions\NotFoundException $exception) {
    show_error($diContainer, 404, 'Page not found');
} catch (\InvalidArgumentException $exception) {
    show_error($diContainer, 400, $exception->getMessage());
} catch (\Phalcon\Mvc\Dispatcher\Exception $exception) {
    show_error($diContainer, 404,'Resource not found');
} catch (\App\Access\Models\Forbidden $exception) {
    show_error($diContainer, 403,'Forbidden');
} catch (\App\Auth\Models\IsNotAuthenticated $exception) {
    show_error($diContainer, 401,'Authentication required');
} catch (\Throwable $exception) {
    show_error($diContainer, 500,getenv('APP_ENV') === 'production' ? 'Server error' : $exception->getMessage());
}

function show_error($diContainer, int $code, string $message) {
    $diContainer->getShared('response')
        ->setStatusCode($code)
        ->setContent(
            $diContainer
                ->get('view')
                ->render(__DIR__ . '/../app/SharedKernel/Views/error', ['code' => $code, 'message' => $message]))
        ->send();
}
