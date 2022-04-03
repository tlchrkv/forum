<?php

declare(strict_types=1);

return [
    'user:add' => [
        'pattern' => '/add-user',
        'paths' => [
            'namespace' => 'App\User\Controllers',
            'controller' => 'add',
            'action' => 'exec',
        ],
        'httpMethods' => ['GET', 'POST'],
    ],
    'user:delete' => [
        'pattern' => '/users/:id/delete',
        'paths' => [
            'namespace' => 'App\User\Controllers',
            'controller' => 'delete',
            'action' => 'exec',
        ],
        'httpMethods' => ['GET'],
    ],
];
