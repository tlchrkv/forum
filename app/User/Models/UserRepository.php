<?php

declare(strict_types=1);

namespace App\User\Models;

use Ramsey\Uuid\UuidInterface;

final class UserRepository
{
    /**
     * @throws UserNotFound
     */
    public function get(UuidInterface $id)
    {
        $user = User::findFirst($id);

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
}
