<?php

declare(strict_types=1);

return [
    'category:add' => [
        'pattern' => '/add-category',
        'paths' => [
            'namespace' => 'App\Forum\Category\Controllers',
            'controller' => 'add',
            'action' => 'main',
        ],
        'httpMethods' => ['GET', 'POST'],
    ],
    'category:delete' => [
        'pattern' => '/categories/:id/delete',
        'paths' => [
            'namespace' => 'App\Forum\Category\Controllers',
            'controller' => 'delete',
            'action' => 'main',
        ],
        'httpMethods' => ['GET'],
    ],
    'category:index' => [
        'pattern' => '/',
        'paths' => [
            'namespace' => 'App\Forum\Category\Controllers',
            'controller' => 'index',
            'action' => 'main',
        ],
        'httpMethods' => ['GET'],
    ],
    'category:show' => [
        'pattern' => '/:name',
        'paths' => [
            'namespace' => 'App\Forum\Category\Controllers',
            'controller' => 'show',
            'action' => 'main',
        ],
        'httpMethods' => ['GET'],
    ],
];
