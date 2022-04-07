<?php

declare(strict_types=1);

namespace App\Forum\Category\Controllers;

use App\Access\Models\AccessChecker\Forum\CategoryAccessChecker;
use App\Access\Models\Forbidden;
use App\Auth\Models\Auth;
use App\Forum\Category\Models\CategoryRepository;
use App\SharedKernel\Http\Validation;
use Ramsey\Uuid\Uuid;

final class EditController extends \Phalcon\Mvc\Controller
{
    public function mainAction(string $id)
    {
        if (!$this->getCategoryAccessChecker()->canChange($id)) {
            throw new Forbidden();
        }

        if ($this->request->isPost()) {
            $validation = new Validation([
                'name' => 'required|length_between:1,64',
            ]);

            $validation->validate($_POST);

            $user = $this->getAuth()->getUserFromSession();

            $category = $this->getCategoryRepository()->get(Uuid::fromString($id));
            $category->edit($_POST['name'], Uuid::fromString($user->id));

            $this->response->redirect('/' . $category->slug);

            return;
        }

        echo $this->view->render(
            __DIR__ . '/../Views/edit',
            [
                'category' => $this->getCategoryRepository()->get(Uuid::fromString($id)),
            ]
        );
    }

    private function getCategoryAccessChecker(): CategoryAccessChecker
    {
        return new CategoryAccessChecker();
    }

    private function getAuth(): Auth
    {
        return new Auth();
    }

    private function getCategoryRepository(): CategoryRepository
    {
        return new CategoryRepository();
    }
}
