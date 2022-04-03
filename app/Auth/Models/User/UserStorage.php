<?php

declare(strict_types=1);

namespace App\Auth\Models\User;

use Ramsey\Uuid\UuidInterface;

interface UserStorage
{
    /**
     * @return UserNotFound
     */
    public function get(UuidInterface $id): User;

    /**
     * @return UserNotFound
     */
    public function getByName(string $name): User;
}
