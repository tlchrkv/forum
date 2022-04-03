<?php

declare(strict_types=1);

return [
    'migrate' => [
        'desc' => 'Execute migrations',
        'namespace' => 'App\SharedKernel\Tasks',
        'slug' => 'run-migration',
        'action' => 'main',
    ],
];
