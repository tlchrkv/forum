<?php

declare(strict_types=1);

namespace App\Access\Adapters;

use App\Access\Models\AuthenticatedUserResolver\User;
use App\Access\Models\AuthenticatedUserResolver\UserResolver;
use App\Access\Models\AuthenticatedUserResolver\UserRoleResolver;
use App\Auth\Models\Auth;
use App\Auth\Models\IsNotAuthenticated;

final class AuthAdapter implements UserResolver
{
    private $auth;
    private $userRoleResolver;

    public function __construct(Auth $auth, UserRoleResolver $userRoleResolver)
    {
        $this->auth = $auth;
        $this->userRoleResolver = $userRoleResolver;
    }

    public function getUser(): ?User
    {
        try {
            $user = $this->auth->getUserFromSession();

            return new User(
                $user->id,
                $user->name,
                $this->userRoleResolver->getRole($user->id)
            );
        } catch (IsNotAuthenticated $exception) {
            return null;
        }
    }
}
