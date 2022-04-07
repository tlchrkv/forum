<?php

declare(strict_types=1);

namespace App\User\Controllers;

use App\Access\Models\AccessChecker\User\AccessChecker;
use App\Access\Models\Forbidden;
use App\Access\Models\Role;
use App\Auth\Models\Auth;
use App\SharedKernel\Http\Validation;
use App\User\Models\User;
use App\User\Models\UserRepository;
use Ramsey\Uuid\Uuid;

final class AddController extends \Phalcon\Mvc\Controller
{
    public function mainAction(): void
    {
        if (!$this->getAccessChecker()->canManageUsers()) {
            throw new Forbidden();
        }

        if ($this->request->isPost()) {
            $validation = new Validation([
                'name' => 'required|length_between:1,64',
                'password' => 'required|length_between:1,255',
            ]);

            $validation->validate($_POST);

            $user = $this->getAuth()->getUserFromSession();

            User::add(
                Uuid::uuid4(),
                $_POST['name'],
                $_POST['password'],
                Role::user(),
                Uuid::fromString($user->id)
            );

            $this->response->redirect('/users');
        }

        echo $this->view->render(__DIR__ . '/../Views/add');
    }

    private function getAuth(): Auth
    {
        return new Auth();
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
