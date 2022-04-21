<?php

declare(strict_types=1);

return [
    'file:image-preview' => [
        'pattern' => '/images/{id}',
        'paths' => [
            'namespace' => 'App\SharedKernel\File\Controllers',
            'controller' => 'image_preview',
            'action' => 'main',
        ],
        'httpMethods' => ['GET'],
    ],
    'file:delete' => [
        'pattern' => '/files/{id}/delete',
        'paths' => [
            'namespace' => 'App\SharedKernel\File\Controllers',
            'controller' => 'delete',
            'action' => 'main',
        ],
        'httpMethods' => ['GET'],
    ],
];
