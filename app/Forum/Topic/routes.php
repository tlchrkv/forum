<?php

declare(strict_types=1);

return [
    'topic:show' => [
        'pattern' => '/{categorySlug}/{slug}',
        'paths' => [
            'namespace' => 'App\Forum\Topic\Controllers',
            'controller' => 'show',
            'action' => 'main',
        ],
        'httpMethods' => ['GET'],
    ],
    'topic:add' => [
        'pattern' => '/{categorySlug}/add-topic',
        'paths' => [
            'namespace' => 'App\Forum\Topic\Controllers',
            'controller' => 'add',
            'action' => 'main',
        ],
        'httpMethods' => ['GET', 'POST'],
    ],
    'topic:delete' => [
        'pattern' => '/topics/{id}/delete',
        'paths' => [
            'namespace' => 'App\Forum\Topic\Controllers',
            'controller' => 'delete',
            'action' => 'main',
        ],
        'httpMethods' => ['GET'],
    ],
    'topic:edit' => [
        'pattern' => '/topics/{id}',
        'paths' => [
            'namespace' => 'App\Forum\Topic\Controllers',
            'controller' => 'edit',
            'action' => 'main',
        ],
        'httpMethods' => ['GET', 'POST'],
    ],
];
