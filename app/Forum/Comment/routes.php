<?php

declare(strict_types=1);

return [
    'comment:add' => [
        'pattern' => '/{categorySlug}/{topicSlug}/add-comment',
        'paths' => [
            'namespace' => 'App\Forum\Comment\Controllers',
            'controller' => 'add',
            'action' => 'main',
        ],
        'httpMethods' => ['GET', 'POST'],
    ],
    'comment:delete' => [
        'pattern' => '/comments/{id}/delete',
        'paths' => [
            'namespace' => 'App\Forum\Comment\Controllers',
            'controller' => 'delete',
            'action' => 'main',
        ],
        'httpMethods' => ['GET'],
    ],
    'comment:edit' => [
        'pattern' => '/comments/{id}',
        'paths' => [
            'namespace' => 'App\Forum\Comment\Controllers',
            'controller' => 'edit',
            'action' => 'main',
        ],
        'httpMethods' => ['GET', 'POST'],
    ],
];
