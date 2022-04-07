<?php

declare(strict_types=1);

return [
    'access:moderate-categories' => [
        'pattern' => '/access/users/{userId}/moderate-categories',
        'paths' => [
            'namespace' => 'App\Access\Controllers',
            'controller' => 'moderate-categories',
            'action' => 'main',
        ],
        'httpMethods' => ['GET', 'POST'],
    ],
    'access:delete-moderate-category' => [
        'pattern' => '/access/users/{userId}/moderate-categories/{categoryId}/delete',
        'paths' => [
            'namespace' => 'App\Access\Controllers',
            'controller' => 'delete-moderate-category',
            'action' => 'main',
        ],
        'httpMethods' => ['GET'],
    ],
    'access:assign-category' => [
        'pattern' => '/access/users/{userId}/assign-category',
        'paths' => [
            'namespace' => 'App\Access\Controllers',
            'controller' => 'assign-category',
            'action' => 'main',
        ],
        'httpMethods' => ['GET', 'POST'],
    ],
    'access:assign-role' => [
        'pattern' => '/access/users/{userId}/assign-role',
        'paths' => [
            'namespace' => 'App\Access\Controllers',
            'controller' => 'assign-role',
            'action' => 'main',
        ],
        'httpMethods' => ['GET', 'POST'],
    ],
];
