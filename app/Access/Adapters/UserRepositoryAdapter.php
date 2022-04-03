<?php

declare(strict_types=1);

namespace App\Access\Adapters;

use App\Access\Models\Role;
use App\Access\Models\AuthenticatedUserResolver\UserRoleResolver;
use App\User\Models\UserRepository;
use Ramsey\Uuid\UuidInterface;

final class UserRepositoryAdapter implements UserRoleResolver
{
    private $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function getRole(UuidInterface $id): Role
    {
        return Role::fromValue($this->userRepository->get($id)->role);
    }
}
