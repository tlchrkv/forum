<?php

declare(strict_types=1);

namespace App\Access\Models\AccessChecker\Forum;

use App\Access\Models\AuthenticatedUserResolver\UserResolver;
use App\Access\Models\Role;
use App\Access\Models\AccessChecker\Forum\ModerateCategory\SessionStorage\CategoryIdsGetter;
use Ramsey\Uuid\UuidInterface;

final class CommentAccessChecker
{
    private $userResolver;
    private $categoryIdsGetter;

    public function __construct(UserResolver $userResolver, CategoryIdsGetter $categoryIdsGetter)
    {
        $this->userResolver = $userResolver;
        $this->categoryIdsGetter = $categoryIdsGetter;
    }

    public function canAdd(): bool
    {
        return true;
    }

    public function canChange(UuidInterface $categoryId, UuidInterface $authorId): bool
    {
        $user = $this->userResolver->getUser();

        if ($user === null) {
            return false;
        }

        if ($authorId === $user->id) {
            return true;
        }

        if ($user->role == Role::admin()) {
            return true;
        }

        if ($user->role == Role::moderator()) {
            return in_array($categoryId->toString(), $this->categoryIdsGetter->exec());
        }

        return false;
    }
}
