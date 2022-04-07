<?php

declare(strict_types=1);

namespace App\Access\Controllers;

use App\Access\Models\AccessChecker\Access\AccessChecker;
use App\Access\Models\AccessChecker\Forum\ModerateCategory\ModerateCategoryRepository;
use App\Access\Models\Forbidden;
use App\Auth\Models\Auth;
use App\Forum\Category\Models\CategoryRepository;
use App\SharedKernel\Http\Validation;
use App\User\Models\UserRepository;

final class ModerateCategoriesController extends \Phalcon\Mvc\Controller
{
    public function mainAction(string $userId): void
    {
        if (!$this->getAccessChecker()->canManageAccesses()) {
            throw new Forbidden();
        }

        $user = $this->getUserRepository()->get($userId);

        echo $this->view->render(
            __DIR__ . '/../Views/moderate-categories',
            [
                'user1' => $user,
                'categories' => $this->getModerateCategoryRepository()->findByUserId($userId),
            ]
        );
    }

    private function getModerateCategoryRepository(): ModerateCategoryRepository
    {
        return new ModerateCategoryRepository();
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
