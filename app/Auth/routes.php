<?php

declare(strict_types=1);

return [
    'auth:login' => [
        'pattern' => '/login',
        'paths' => [
            'namespace' => 'App\Auth\Controllers',
            'controller' => 'login',
            'action' => 'exec',
        ],
        'httpMethods' => ['GET', 'POST'],
    ],
    'auth:logout' => [
        'pattern' => '/logout',
        'paths' => [
            'namespace' => 'App\Auth\Controllers',
            'controller' => 'logout',
            'action' => 'exec',
        ],
        'httpMethods' => ['GET'],
    ],
];
