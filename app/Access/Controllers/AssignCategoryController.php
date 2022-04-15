<?php

declare(strict_types=1);

namespace App\Access\Controllers;

use App\Access\Models\AccessChecker\Access\AccessChecker;
use App\Access\Models\AccessChecker\Forum\ModerateCategory\ModerateCategory;
use App\Access\Models\Forbidden;
use App\Auth\Models\Auth;
use App\Forum\Category\Models\CategoryWriteRepository;
use App\SharedKernel\Http\Validation;
use App\User\Models\UserRepository;

final class AssignCategoryController extends \Phalcon\Mvc\Controller
{
    public function mainAction(string $userId): void
    {
        if (!$this->getAccessChecker()->canManageAccesses()) {
            throw new Forbidden();
        }

        $user = $this->getUserRepository()->get($userId);

        if ($this->request->isPost()) {
            $validation = new Validation([
                'category_id' => 'required',
            ]);
            $validation->validate($_POST);

            ModerateCategory::add($_POST['category_id'], $userId);

            $this->response->redirect('/access/users/' . $userId . '/moderate-categories');
            return;
        }

        echo $this->view->render(
            __DIR__ . '/../Views/assign-category',
            [
                'user1' => $user,
                'categories' => $this->getCategoryRepository()->findAll(),
            ]
        );
    }

    private function getCategoryRepository(): CategoryWriteRepository
    {
        return new CategoryWriteRepository();
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
