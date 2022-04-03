<?php

declare(strict_types=1);

namespace App\Auth\Models;

use App\Access\Models\AccessChecker\Forum\ModerateCategory\SessionStorage\CategoryIdsDestroyer;
use App\Access\Models\AccessChecker\Forum\ModerateCategory\SessionStorage\CategoryIdsSetter;
use App\User\Models\User;
use App\User\Models\UserNotFound;
use App\User\Models\UserRepository;
use Ramsey\Uuid\Uuid;

final class Auth
{
    private $userRepository;
    private $accessSessionSetter;
    private $accessSessionDestroyer;

    public function __construct()
    {
        $this->userRepository = new UserRepository();
        $this->accessSessionSetter = new CategoryIdsSetter();
        $this->accessSessionDestroyer = new CategoryIdsDestroyer();
    }

    /**
     * @return LoginFailed
     */
    public function login(string $name, string $password): void
    {
        try {
            $user = $this->userRepository->getByName($name);
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

            return $this->userRepository->get($userId);
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
        return \Phalcon\DI::getDefault()->getShared('session');
    }
}
