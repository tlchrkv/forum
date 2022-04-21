<?php

declare(strict_types=1);

namespace App\Forum\Category\Controllers;

use App\Access\Models\AccessChecker\Forum\CategoryAccessChecker;
use App\Access\Models\Forbidden;
use App\Auth\Models\Auth;
use App\Forum\Category\Models\CategoryWriteRepository;
use App\SharedKernel\Controllers\ModuleViewRender;
use App\SharedKernel\Controllers\Validation;

final class EditController extends \Phalcon\Mvc\Controller
{
    use ModuleViewRender;
    use Validation;

    public function mainAction(string $id)
    {
        if (!$this->getCategoryAccessChecker()->canChange($id)) {
            throw new Forbidden();
        }

        $category = $this->getCategoryRepository()->get($id);

        if ($this->request->isPost()) {
            $this->validatePostRequest(['name' => 'required|length_between:1,64']);

            $user = $this->getAuth()->getUserFromSession();

            $category->edit($_POST['name'], $user->id);

            $this->response->redirect('/' . $category->slug);

            return;
        }

        $this->renderView(['category' => $category]);
    }

    private function getCategoryAccessChecker(): CategoryAccessChecker
    {
        return new CategoryAccessChecker();
    }

    private function getAuth(): Auth
    {
        return new Auth();
    }

    private function getCategoryRepository(): CategoryWriteRepository
    {
        return new CategoryWriteRepository();
    }
}
