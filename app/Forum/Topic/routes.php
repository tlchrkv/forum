<?php

declare(strict_types=1);

return [
    'topic:add' => [
        'pattern' => '/:category/add-topic',
        'paths' => [
            'namespace' => 'App\Forum\Topic\Controllers',
            'controller' => 'add',
            'action' => 'main',
        ],
        'httpMethods' => ['GET', 'POST'],
    ],
    'topic:delete' => [
        'pattern' => '/topics/:id/delete',
        'paths' => [
            'namespace' => 'App\Forum\Topic\Controllers',
            'controller' => 'delete',
            'action' => 'main',
        ],
        'httpMethods' => ['GET'],
    ],
    'topic:show' => [
        'pattern' => '/:category/:name',
        'paths' => [
            'namespace' => 'App\Forum\Topic\Controllers',
            'controller' => 'show',
            'action' => 'main',
        ],
        'httpMethods' => ['GET'],
    ],
];
