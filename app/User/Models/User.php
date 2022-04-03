<?php

declare(strict_types=1);

namespace App\User\Models;

use Ramsey\Uuid\UuidInterface;

final class User extends \Phalcon\Mvc\Model
{
    public function initialize(): void
    {
        $this->setSource('users');
    }

    public static function create(
        UuidInterface $id,
        string $name,
        string $password,
        string $role,
        UuidInterface $userId = null
    ): void {
        $user = new self([
            'id' => $id,
            'name' => $name,
            'password_hash' => hash('sha256', $password),
            'role' => $role,
            'created_at' => new \DateTime('now'),
            'created_by' => $userId,
        ]);

        $user->save();
    }

    public function assignRole(string $role, $userId): void
    {

    }
}
