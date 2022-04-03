<?php

declare(strict_types=1);

return [
    'access:assign-category' => [
        'pattern' => '/access/users/:id/assign-category',
        'paths' => [
            'namespace' => 'App\Access\Controllers',
            'controller' => 'assign-category',
            'action' => 'exec',
        ],
        'httpMethods' => ['GET', 'POST'],
    ],
    'access:assign-role' => [
        'pattern' => '/access/users/:id/assign-role',
        'paths' => [
            'namespace' => 'App\Access\Controllers',
            'controller' => 'assign-role',
            'action' => 'exec',
        ],
        'httpMethods' => ['GET', 'POST'],
    ],
];
