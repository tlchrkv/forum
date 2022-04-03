<?php

declare(strict_types=1);

return array_merge(
    include __DIR__ . '/../app/Auth/routes.php',
    include __DIR__ . '/../app/User/routes.php',
    include __DIR__ . '/../app/Access/routes.php',
    include __DIR__ . '/../app/Forum/Category/routes.php',
    include __DIR__ . '/../app/Forum/Comment/routes.php',
    include __DIR__ . '/../app/Forum/Topic/routes.php'
);
