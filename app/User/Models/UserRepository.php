<?php

declare(strict_types=1);

namespace App\User\Models;

use Phalcon\Mvc\Model\Resultset;

final class UserRepository
{
    /**
     * @throws UserNotFound
     */
    public function get($id): User
    {
        $user = User::findFirst("id = '$id'");

        if ($user === false) {
            throw new UserNotFound();
        }

        return $user;
    }

    /**
     * @throws UserNotFound
     */
    public function getByName(string $name): User
    {
        $user = User::findFirst(['conditions' => 'name = ?0', 'bind' => [$name]]);

        if ($user === false) {
            throw new UserNotFound();
        }

        return $user;
    }

    public function find(int $page, int $limit): Resultset
    {
        return User::find([
            'order' => 'created_at desc',
            'limit' => $limit,
            'offset' => ($page - 1) * $limit,
        ]);
    }

    public function count(): int
    {
        return User::count();
    }
}
