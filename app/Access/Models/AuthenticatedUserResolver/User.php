<?php

declare(strict_types=1);

namespace App\Access\Models\AuthenticatedUserResolver;

use Ramsey\Uuid\UuidInterface;

final class User
{
    public $id;
    public $name;
    public $role;

    public function __construct(UuidInterface $id, string $name, Role $role)
    {
        $this->id = $id;
        $this->name = $name;
        $this->role = $role;
    }
}
