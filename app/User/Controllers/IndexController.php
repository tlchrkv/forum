<?php

namespace App\User\Controllers;

use App\Access\Models\AccessChecker\User\AccessChecker;
use App\Access\Models\Forbidden;
use App\User\Models\UserRepository;

final class IndexController extends \Phalcon\Mvc\Controller
{
    public function mainAction(): void
    {
        if (!$this->getAccessChecker()->canManageUsers()) {
            throw new Forbidden();
        }

        $page = (int) $this->request->getQuery('page', 'int', 1);

        $users = $this->getUserRepository()->find($page, 10);

        echo $this->view->render(
            __DIR__ . '/../Views/index',
            [
                'users' => $users,
                'page' => $page,
                'pages' => ceil($this->getUserRepository()->count() / 10),
            ]
        );
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
