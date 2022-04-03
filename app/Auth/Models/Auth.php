<?php

declare(strict_types=1);

namespace App\Auth\Models;

use App\Auth\Models\AccessLoader\AccessSessionDestroyer;
use App\Auth\Models\AccessLoader\AccessSessionSetter;
use App\Auth\Models\User\User;
use App\Auth\Models\User\UserNotFound;
use App\Auth\Models\User\UserStorage;
use Ramsey\Uuid\Uuid;

final class Auth
{
    private $userStorage;
    private $accessSessionSetter;
    private $accessSessionDestroyer;

    public function __construct(
        UserStorage $userStorage,
        AccessSessionSetter $accessSessionSetter,
        AccessSessionDestroyer $accessSessionDestroyer
    ) {
        $this->userStorage = $userStorage;
        $this->accessSessionSetter = $accessSessionSetter;
        $this->accessSessionDestroyer = $accessSessionDestroyer;
    }

    /**
     * @return LoginFailed
     */
    public function login(string $name, string $password): void
    {
        try {
            $user = $this->userStorage->getByName($name);
        } catch (UserNotFound $exception) {
            throw new LoginFailed();
        }

        if ($user->passwordHash === hash('sha256', $password)) {
            $this->getSession()->set('user_id', $user->id);
            $this->accessSessionSetter->exec($user->id);
        }

        throw new LoginFailed();
    }

    /**
     * @return IsNotAuthenticated
     */
    public function getUserFromSession(): User
    {
        if (!$this->getSession()->has('user_id')) {
            throw new IsNotAuthenticated();
        }

        try {
            $userId = Uuid::fromString($this->getSession()->has('user_id'));

            return $this->userStorage->get($userId);
        } catch (UserNotFound $exception) {
            throw new IsNotAuthenticated();
        }
    }

    public function logout(): void
    {
        $this->accessSessionDestroyer->exec();
        $this->getSession()->destroy();
    }

    private function getSession()
    {
        return di('session', true);
    }
}
