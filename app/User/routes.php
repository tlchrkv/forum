<?php

declare(strict_types=1);

return [
    'user:index' => [
        'pattern' => '/users',
        'paths' => [
            'namespace' => 'App\User\Controllers',
            'controller' => 'index',
            'action' => 'main',
        ],
        'httpMethods' => ['GET'],
    ],
    'user:add' => [
        'pattern' => '/add-user',
        'paths' => [
            'namespace' => 'App\User\Controllers',
            'controller' => 'add',
            'action' => 'main',
        ],
        'httpMethods' => ['GET', 'POST'],
    ],
    'user:delete' => [
        'pattern' => '/users/{id}/delete',
        'paths' => [
            'namespace' => 'App\User\Controllers',
            'controller' => 'delete',
            'action' => 'main',
        ],
        'httpMethods' => ['GET'],
    ],
];
