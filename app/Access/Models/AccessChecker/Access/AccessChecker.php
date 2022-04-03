<?php

declare(strict_types=1);

namespace App\Access\Models\AccessChecker\Access;

use App\Access\Models\AuthenticatedUserResolver\UserResolver;
use App\Access\Models\Role;

final class AccessChecker
{
    private $userResolver;

    public function __construct(UserResolver $userResolver)
    {
        $this->userResolver = $userResolver;
    }

    public function canManageAccesses(): bool
    {
        $user = $this->userResolver->getUser();

        if ($user === null) {
            return false;
        }

        return $user->role == Role::admin();
    }
}
