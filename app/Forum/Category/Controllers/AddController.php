<?php

declare(strict_types=1);

namespace App\Forum\Category\Controllers;

use App\Access\Models\AccessChecker\Forum\CategoryAccessChecker;
use App\Access\Models\Forbidden;
use App\Auth\Models\Auth;
use App\Forum\Category\Models\Category;
use App\SharedKernel\Controllers\ModuleViewRender;
use App\SharedKernel\Controllers\Validation;
use Ramsey\Uuid\Uuid;

final class AddController extends \Phalcon\Mvc\Controller
{
    use ModuleViewRender;
    use Validation;

    public function mainAction()
    {
        if (!$this->getCategoryAccessChecker()->canAdd()) {
            throw new Forbidden();
        }

        if ($this->request->isPost()) {
            try {
                $this->validatePostRequest(['name' => 'required|length_between:1,64']);

                $user = $this->getAuth()->getUserFromSession();

                $category = Category::add(
                    Uuid::uuid4(),
                    $_POST['name'],
                    $user->id
                );

                $this->response->redirect('/' . $category->slug);

                return;
            } catch (\LogicException $e) {
                $this->renderView(['error' => $e->getMessage(), 'name' => $_POST['name']]);

                return;
            }
        }

        $this->renderView();
    }

    private function getCategoryAccessChecker(): CategoryAccessChecker
    {
        return new CategoryAccessChecker();
    }

    private function getAuth(): Auth
    {
        return new Auth();
    }
}
