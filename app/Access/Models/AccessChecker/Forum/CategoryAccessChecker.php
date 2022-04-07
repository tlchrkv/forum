<?php

declare(strict_types=1);

namespace App\Access\Models\AccessChecker\Forum;

use App\Access\Models\Role;
use App\Access\Models\AccessChecker\Forum\ModerateCategory\SessionStorage\CategoryIdsGetter;
use App\Auth\Models\Auth;
use Ramsey\Uuid\UuidInterface;

final class CategoryAccessChecker
{
    private $auth;
    private $categoryIdsGetter;

    public function __construct()
    {
        $this->auth = new Auth();
        $this->categoryIdsGetter = new CategoryIdsGetter();
    }

    public function canAdd(): bool
    {
        $user = $this->auth->getUserFromSession();

        if ($user === null) {
            return false;
        }

        if ($user->role === Role::admin()->value) {
            return true;
        }

        return false;
    }

    public function canDelete(): bool
    {
        $user = $this->auth->getUserFromSession();

        if ($user === null) {
            return false;
        }

        if ($user->role === Role::admin()->value) {
            return true;
        }

        return false;
    }

    public function canChange($categoryId): bool
    {
        $user = $this->auth->getUserFromSession();

        if ($user === null) {
            return false;
        }

        if ($user->role === Role::admin()->value) {
            return true;
        }

        if ($user->role === Role::moderator()->value) {
            return in_array($categoryId, $this->categoryIdsGetter->exec());
        }

        return false;
    }
}
