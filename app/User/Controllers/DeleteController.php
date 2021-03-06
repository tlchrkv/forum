<?php

declare(strict_types=1);

namespace App\User\Controllers;

use App\Access\Models\AccessChecker\User\AccessChecker;
use App\Access\Models\Forbidden;
use App\User\Models\UserRepository;

final class DeleteController extends \Phalcon\Mvc\Controller
{
    public function mainAction(string $id): void
    {
        if (!$this->getAccessChecker()->canManageUsers()) {
            throw new Forbidden();
        }

        $user = $this->getUserRepository()->get($id);
        $user->delete();

        $this->response->redirect('/users');
    }

    private function getUserRepository(): UserRepository
    {
        return new UserRepository();
    }

    private function getAccessChecker(): AccessChecker
    {
        return new AccessChecker();
    }
}
