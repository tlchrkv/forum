<?php

declare(strict_types=1);

namespace App\Access\Models\AuthenticatedUserResolver;

use Ramsey\Uuid\UuidInterface;

interface UserRoleResolver
{
    public function getRole(UuidInterface $id): Role;
}
