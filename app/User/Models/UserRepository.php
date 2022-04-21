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

    public function existByName(string $name): bool
    {
        return 0 < User::count(['conditions' => 'name = ?0', 'bind' => [strtolower($name)]]);
    }

    /**
     * @throws UserNotFound
     */
    public function getByName(string $name): User
    {
        $user = User::findFirst(['conditions' => 'name = ?0', 'bind' => [strtolower($name)]]);

        if ($user === false) {
            throw new UserNotFound();
        }

        return $user;
    }

    public function find(int $count, int $skip): Resultset
    {
        return User::find([
            'order' => 'created_at desc',
            'limit' => $count,
            'offset' => $skip,
        ]);
    }

    public function count(): int
    {
        return User::count();
    }
}
