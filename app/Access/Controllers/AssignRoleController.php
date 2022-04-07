<?php

declare(strict_types=1);

namespace App\Access\Controllers;

use App\Access\Models\AccessChecker\Access\AccessChecker;
use App\Access\Models\Forbidden;
use App\Access\Models\Role;
use App\Auth\Models\Auth;
use App\SharedKernel\Http\Validation;
use App\User\Models\UserRepository;

final class AssignRoleController extends \Phalcon\Mvc\Controller
{
    public function mainAction(string $userId): void
    {
        if (!$this->getAccessChecker()->canManageAccesses()) {
            throw new Forbidden();
        }

        $user = $this->getUserRepository()->get($userId);

        if ($this->request->isPost()) {
            $validation = new Validation([
                'role' => 'required',
            ]);
            $validation->validate($_POST);

            $initiator = $this->getAuth()->getUserFromSession();

            $user->assignRole(Role::fromValue($_POST['role']), $initiator->id);

            $this->response->redirect('/users');
            return;
        }

        echo $this->view->render(
            __DIR__ . '/../Views/assign-role',
            ['user1' => $user]
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

    private function getAuth(): Auth
    {
        return new Auth();
    }
}
