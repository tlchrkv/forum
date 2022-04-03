<?php

declare(strict_types=1);

namespace App\Auth\Models\User;

use Ramsey\Uuid\UuidInterface;

final class User
{
    public $id;
    public $name;
    public $passwordHash;

    public function __construct(UuidInterface $id, string $name, string $passwordHash)
    {
        $this->id = $id;
        $this->name = $name;
        $this->passwordHash = $passwordHash;
    }
}
