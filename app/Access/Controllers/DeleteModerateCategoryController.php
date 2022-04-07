<?php

declare(strict_types=1);

namespace App\Access\Controllers;

use App\Access\Models\AccessChecker\Access\AccessChecker;
use App\Access\Models\AccessChecker\Forum\ModerateCategory\ModerateCategoryRepository;
use App\Access\Models\Forbidden;
use App\Auth\Models\Auth;
use App\User\Models\UserRepository;

final class DeleteModerateCategoryController extends \Phalcon\Mvc\Controller
{
    public function mainAction(string $userId, string $categoryId): void
    {
        if (!$this->getAccessChecker()->canManageAccesses()) {
            throw new Forbidden();
        }

        $moderateCategory = $this->getModerateCategoryRepository()->getByUserIdAndCategoryId($userId, $categoryId);
        $moderateCategory->delete();

        $this->response->redirect('/access/users/' . $userId . '/moderate-categories');
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
