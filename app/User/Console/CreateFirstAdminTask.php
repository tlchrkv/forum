<?php

declare(strict_types=1);

namespace App\User\Console;

use App\Access\Models\Role;
use App\User\Models\User;
use App\User\Models\UserNotFound;
use App\User\Models\UserRepository;
use Ramsey\Uuid\Uuid;

final class CreateFirstAdminTask extends \Phalcon\Cli\Task
{
    public function mainAction(): void
    {
        try {
            $this->getUserRepository()->getByName($this->config['user']['admin_name']);

            echo 'Default admin user already exists' . PHP_EOL;
        } catch (UserNotFound $exception) {
            User::add(
                Uuid::uuid4(),
                $this->config['user']['admin_name'],
                $this->config['user']['admin_password'],
                Role::admin()
            );

            echo 'Admin user created' . PHP_EOL;
            echo 'Name: ' . $this->config['user']['admin_name'] . PHP_EOL;
            echo 'Password: ' . $this->config['user']['admin_password'] . PHP_EOL;
        }
    }

    private function getUserRepository(): UserRepository
    {
        return new UserRepository();
    }
}
