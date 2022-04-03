<?php

declare(strict_types=1);

namespace App\Access\Models\AuthenticatedUserResolver;

interface UserResolver
{
    public function getUser(): ?User;
}
