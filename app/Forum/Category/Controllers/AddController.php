<?php

declare(strict_types=1);

namespace App\Forum\Category\Controllers;

use App\Access\Models\AccessChecker\Forum\CategoryAccessChecker;
use App\Access\Models\Forbidden;
use App\Auth\Models\Auth;
use App\Forum\Category\Models\Category;
use App\SharedKernel\Http\Validation;
use Ramsey\Uuid\Uuid;

final class AddController extends \Phalcon\Mvc\Controller
{
    public function mainAction(): void
    {
        if (!$this->getCategoryAccessChecker()->canAdd()) {
            throw new Forbidden();
        }

        if ($this->request->isPost()) {
            $validation = new Validation([
                'name' => 'required|length_between:1,64',
            ]);

            $validation->validate($_POST);

            $user = $this->getAuth()->getUserFromSession();

            Category::add(
                Uuid::uuid4(),
                $_POST['name'],
                $user->id
            );
        }

        echo $this->view->render(__DIR__ . '/../Views/add');
    }

    private function getCategoryAccessChecker(): CategoryAccessChecker
    {
        return di(CategoryAccessChecker::class);
    }

    private function getAuth(): Auth
    {
        return di(Auth::class);
    }
}
