<?php

declare(strict_types=1);

namespace App\Auth\Adapters;

use App\Auth\Models\User\User;
use App\Auth\Models\User\UserNotFound;
use App\Auth\Models\User\UserStorage;
use App\User\Models\UserNotFound as UserModule_UserNotFound;
use App\User\Models\UserRepository;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

final class UserRepositoryAdapter implements UserStorage
{
    private $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * @return UserNotFound
     */
    public function get(UuidInterface $id): User
    {
        try {
            $user =  $this->userRepository->get($id);
        } catch (UserModule_UserNotFound $exception) {
            throw new UserNotFound();
        }

        return new User($id, $user->name, $user->password_hash);
    }

    /**
     * @return UserNotFound
     */
    public function getByName(string $name): User
    {
        try {
            $user =  $this->userRepository->getByName($name);
        } catch (UserModule_UserNotFound $exception) {
            throw new UserNotFound();
        }

        return new User(Uuid::fromString($user->id), $user->name, $user->password_hash);
    }
}
