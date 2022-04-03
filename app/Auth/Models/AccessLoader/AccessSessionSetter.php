<?php

declare(strict_types=1);

namespace App\Auth\Models\AccessLoader;

use Ramsey\Uuid\UuidInterface;

interface AccessSessionSetter
{
    public function exec(UuidInterface $userId): void;
}
