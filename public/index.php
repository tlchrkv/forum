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
use Phalcon\DI;

require_once __DIR__ . '/../vendor/autoload.php';

$diContainer = new FactoryDefault();

$application = new Application($diContainer);
$application->useImplicitView(false);

// get service from DI
function di(string $service, bool $isShared = false) {
    if ($isShared) {
        return DI::getDefault()->getShared($service);
    }
    return DI::getDefault()->get($service);
}

// Services
// User
$diContainer->set(\App\User\Models\UserRepository::class, function () {
    return new \App\User\Models\UserRepository();
});

// Access 2
$diContainer->set(\App\Access\Models\AccessChecker\Forum\ModerateCategory\ModerateCategoryRepository::class, function () {
    return new \App\Access\Models\AccessChecker\Forum\ModerateCategory\ModerateCategoryRepository();
});
$diContainer->set(\App\Access\Models\AccessChecker\Forum\ModerateCategory\SessionStorage\CategoryIdsSetter::class, function () {
    return new \App\Access\Models\AccessChecker\Forum\ModerateCategory\SessionStorage\CategoryIdsSetter(
        di(\App\Access\Models\AccessChecker\Forum\ModerateCategory\ModerateCategoryRepository::class)
    );
});
$diContainer->set(\App\Access\Models\AccessChecker\Forum\ModerateCategory\SessionStorage\CategoryIdsGetter::class, function () {
    return new \App\Access\Models\AccessChecker\Forum\ModerateCategory\SessionStorage\CategoryIdsGetter();
});
$diContainer->set(\App\Access\Models\AccessChecker\Forum\ModerateCategory\SessionStorage\CategoryIdsDestroyer::class, function () {
    return new \App\Access\Models\AccessChecker\Forum\ModerateCategory\SessionStorage\CategoryIdsDestroyer();
});

// Auth
$diContainer->set(\App\Auth\Models\User\UserStorage::class, function () {
    return new \App\Auth\Adapters\UserRepositoryAdapter(
        di(\App\User\Models\UserRepository::class)
    );
});
$diContainer->set(\App\Auth\Models\AccessLoader\AccessSessionSetter::class, function () {
    return new \App\Auth\Adapters\AccessSessionSetterAdapter(
        di(\App\Access\Models\AccessChecker\Forum\ModerateCategory\SessionStorage\CategoryIdsSetter::class)
    );
});
$diContainer->set(\App\Auth\Models\AccessLoader\AccessSessionDestroyer::class, function () {
    return new \App\Auth\Adapters\AccessSessionDestroyerAdapter(
        di(\App\Access\Models\AccessChecker\Forum\ModerateCategory\SessionStorage\CategoryIdsDestroyer::class)
    );
});
$diContainer->set(\App\Auth\Models\User\UserStorage::class, function () {
    return new \App\Auth\Adapters\UserRepositoryAdapter(
        di(\App\User\Models\UserRepository::class)
    );
});
$diContainer->set(\App\Auth\Models\Auth::class, function () {
    return new \App\Auth\Models\Auth(
        di(\App\Auth\Models\User\UserStorage::class),
        di(\App\Auth\Models\AccessLoader\AccessSessionSetter::class),
        di(\App\Auth\Models\AccessLoader\AccessSessionDestroyer::class)
    );
});

// Access
$diContainer->set(\App\Access\Models\AuthenticatedUserResolver\UserRoleResolver::class, function () {
    return new \App\Access\Adapters\UserRepositoryAdapter(
        di(\App\User\Models\UserRepository::class)
    );
});
$diContainer->set(\App\Access\Models\AuthenticatedUserResolver\UserResolver::class, function () {
    return new \App\Access\Adapters\AuthAdapter(
        di(\App\Auth\Models\Auth::class),
        di(\App\Access\Models\AuthenticatedUserResolver\UserRoleResolver::class)
    );
});
$diContainer->set(\App\Access\Models\AccessChecker\User\AccessChecker::class, function () {
    return new \App\Access\Models\AccessChecker\User\AccessChecker(
        di(\App\Access\Models\AuthenticatedUserResolver\UserResolver::class)
    );
});
$diContainer->set(\App\Access\Models\AccessChecker\Access\AccessChecker::class, function () {
    return new \App\Access\Models\AccessChecker\Access\AccessChecker(
        di(\App\Access\Models\AuthenticatedUserResolver\UserResolver::class)
    );
});
$diContainer->set(\App\Access\Models\AccessChecker\Forum\CategoryAccessChecker::class, function () {
    return new \App\Access\Models\AccessChecker\Forum\CategoryAccessChecker(
        di(\App\Access\Models\AuthenticatedUserResolver\UserResolver::class),
        di(\App\Access\Models\AccessChecker\Forum\ModerateCategory\SessionStorage\CategoryIdsGetter::class)
    );
});
$diContainer->set(\App\Access\Models\AccessChecker\Forum\CommentAccessChecker::class, function () {
    return new \App\Access\Models\AccessChecker\Forum\CommentAccessChecker(
        di(\App\Access\Models\AuthenticatedUserResolver\UserResolver::class),
        di(\App\Access\Models\AccessChecker\Forum\ModerateCategory\SessionStorage\CategoryIdsGetter::class)
    );
});
$diContainer->set(\App\Access\Models\AccessChecker\Forum\TopicAccessChecker::class, function () {
    return new \App\Access\Models\AccessChecker\Forum\TopicAccessChecker(
        di(\App\Access\Models\AuthenticatedUserResolver\UserResolver::class),
        di(\App\Access\Models\AccessChecker\Forum\ModerateCategory\SessionStorage\CategoryIdsGetter::class)
    );
});

// Forum
// Category, Comment, Topic Repos
$diContainer->set(\App\Forum\Category\Models\CategoryRepository::class, function () {
    return new \App\Forum\Category\Models\CategoryRepository();
});
$diContainer->set(\App\Forum\Comment\Models\CommentRepository::class, function () {
    return new \App\Forum\Comment\Models\CommentRepository();
});
$diContainer->set(\App\Forum\Topic\Models\TopicRepository::class, function () {
    return new \App\Forum\Topic\Models\TopicRepository();
});


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
    return $view;
});

$diContainer->setShared('config', function () {
    return include __DIR__ . '/../config/config.php';
});

try {
    $application->handle()->getContent();
} catch (\App\SharedKernel\Exceptions\NotFoundException $exception) {
    diShared('response')
        ->setStatusCode(404)
        ->setJsonContent([
            'error' => $exception->getMessage(),
        ])
        ->send();
} catch (App\SharedKernel\Exceptions\AccessDeniedException $exception) {
    diShared('response')
        ->setStatusCode(403)
        ->setJsonContent([
            'error' => $exception->getMessage(),
        ])
        ->send();
} catch (\InvalidArgumentException $exception) {
    diShared('response')
        ->setStatusCode(400)
        ->setJsonContent([
            'error' => $exception->getMessage(),
        ])
        ->send();
//} catch (\Phalcon\Mvc\Dispatcher\Exception $exception) {
//    diShared('response')
//        ->setStatusCode(404)
//        ->setJsonContent([
//            'error' => 'Resource not found',
//        ])
//        ->send();
} catch (\App\Access\Models\Forbidden $exception) {
    diShared('response')
        ->setStatusCode(500)
        ->setJsonContent([
            'error' => 'Forbidden',
        ])
        ->send();
} catch (\Throwable $exception) {
    diShared('response')
        ->setStatusCode(500)
        ->setJsonContent([
            'error' => getenv('APP_ENV') === 'production' ? 'Server error' : $exception->getMessage(),
        ])
        ->send();
}
