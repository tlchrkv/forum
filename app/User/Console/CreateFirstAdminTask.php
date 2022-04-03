<?php

declare(strict_types=1);

namespace App\User\Console;

use App\User\Models\User;
use Ramsey\Uuid\Uuid;

final class CreateFirstAdminTask extends \Phalcon\Cli\Task
{
    public function mainAction(): void
    {
        User::create(
            Uuid::uuid4(),
            $this->config['user']['admin_name'],
            $this->config['user']['admin_password'],
            'admin'
        );

        echo 'Admin user created' . PHP_EOL;
        echo 'Name: ' . $this->config['user']['admin_name'] . PHP_EOL;
        echo 'Password: ' . $this->config['user']['admin_password'] . PHP_EOL;
    }
}
