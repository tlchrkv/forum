<?php

declare(strict_types=1);

namespace App\User\Models;

use App\Access\Models\Role;

final class User extends \Phalcon\Mvc\Model
{
    public function initialize(): void
    {
        $this->setSource('users');
    }

    public static function add(
        $id,
        string $name,
        string $password,
        Role $role,
        $userId = null
    ): void {
        if ((new UserRepository())->existByName($name)) {
            throw new UserAlreadyExist();
        }

        $user = new self([
            'id' => $id,
            'name' => strtolower($name),
            'password_hash' => hash('sha256', $password),
            'role' => $role,
            'created_at' => (new \DateTime('now'))->format('Y-m-d H:i:s'),
            'created_by' => $userId,
        ]);

        $user->save();
    }

    public function assignRole(Role $role, $userId): void
    {
        $this->role = $role;
        $this->updated_at = (new \DateTime('now'))->format('Y-m-d H:i:s');
        $this->updated_by = $userId;
        $this->save();
    }
}
