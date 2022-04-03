<?php

declare(strict_types=1);

return [
    'app_env' => getenv('APP_ENV'),
    'app_name' => getenv('APP_NAME'),
    'user' => include __DIR__ . '/../app/User/config.php',
];
