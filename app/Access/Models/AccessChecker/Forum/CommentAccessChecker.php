<?php

declare(strict_types=1);

namespace App\Access\Models\AccessChecker\Forum;

use App\Access\Models\Role;
use App\Access\Models\AccessChecker\Forum\ModerateCategory\SessionStorage\CategoryIdsGetter;
use App\Auth\Models\Auth;
use Ramsey\Uuid\UuidInterface;

final class CommentAccessChecker
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
        return true;
    }

    public function canDelete($categoryId, $authorId): bool
    {
        $user = $this->auth->getUserFromSession();

        if ($user === null) {
            return false;
        }

        if ($authorId === $user->id) {
            return true;
        }

        if ($user->role === Role::admin()->value) {
            return true;
        }

        if ($user->role === Role::moderator()->value) {
            return in_array($categoryId, $this->categoryIdsGetter->exec());
        }

        return false;
    }

    public function canChange($categoryId, $authorId): bool
    {
        $user = $this->auth->getUserFromSession();

        if ($user === null) {
            return false;
        }

        if ($authorId === $user->id) {
            return true;
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
