<?php

declare(strict_types=1);

namespace App\Access\Models\AccessChecker\Access;

use App\Access\Models\Role;
use App\Auth\Models\Auth;

final class AccessChecker
{
    private $auth;

    public function __construct()
    {
        $this->auth = new Auth();
    }

    public function canManageAccesses(): bool
    {
        $user = $this->auth->getUserFromSession();

        if ($user === null) {
            return false;
        }

        return $user->role == Role::admin()->value;
    }
}
