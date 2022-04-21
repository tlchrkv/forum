<?php

declare(strict_types=1);

namespace App\User\Controllers;

use App\Access\Models\AccessChecker\User\AccessChecker;
use App\Access\Models\Forbidden;
use App\Access\Models\Role;
use App\Auth\Models\Auth;
use App\SharedKernel\Controllers\ModuleViewRender;
use App\SharedKernel\Http\Validation;
use App\User\Models\User;
use Ramsey\Uuid\Uuid;

final class AddController extends \Phalcon\Mvc\Controller
{
    use ModuleViewRender;

    public function mainAction(): void
    {
        if (!$this->getAccessChecker()->canManageUsers()) {
            throw new Forbidden();
        }

        if ($this->request->isPost()) {
            try {
                $validation = new Validation([
                    'name' => 'required|length_between:3,36',
                    'password' => 'required|length_between:6,36',
                ]);

                $validation->validate($_POST);

                $user = $this->getAuth()->getUserFromSession();

                $addingUserId = Uuid::uuid4();

                User::add(
                    $addingUserId,
                    $_POST['name'],
                    $_POST['password'],
                    Role::user(),
                    $user->id
                );

                $this->response->redirect('/users/' . $addingUserId);
            } catch (\LogicException $e) {
                $this->renderView(['error' => $e->getMessage(), 'name' => $_POST['name']]);

                return;
            }
        }

        $this->renderView();
    }

    private function getAuth(): Auth
    {
        return new Auth();
    }

    private function getAccessChecker(): AccessChecker
    {
        return new AccessChecker();
    }
}
