<?php

declare(strict_types=1);

namespace App\Access\Models\AccessChecker\User;

use App\Access\Models\Role;
use App\Auth\Models\Auth;

final class AccessChecker
{
    private $auth;

    public function __construct()
    {
        $this->auth = new Auth();
    }

    public function canManageUsers(): bool
    {
        $user = $this->auth->getUserFromSession();

        if ($user === null) {
            return false;
        }

        return $user->role === Role::admin()->value;
    }
}
