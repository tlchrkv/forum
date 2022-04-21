<?php

declare(strict_types=1);

namespace App\User\Controllers;

use App\Access\Models\AccessChecker\User\AccessChecker;
use App\Access\Models\Forbidden;
use App\SharedKernel\Controllers\ModuleViewRender;
use App\User\Models\UserRepository;

final class ShowController extends \Phalcon\Mvc\Controller
{
    use ModuleViewRender;

    public function mainAction(string $id): void
    {
        if (!$this->getAccessChecker()->canManageUsers()) {
            throw new Forbidden();
        }

        $this->renderView(['user1' => $this->getUserRepository()->get($id)]);
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
