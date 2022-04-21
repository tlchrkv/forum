<?php

namespace App\User\Controllers;

use App\Access\Models\AccessChecker\User\AccessChecker;
use App\Access\Models\Forbidden;
use App\SharedKernel\Controllers\ModuleViewRender;
use App\SharedKernel\Controllers\Pagination;
use App\User\Models\UserRepository;

final class IndexController extends \Phalcon\Mvc\Controller
{
    use ModuleViewRender;
    use Pagination;

    public function mainAction(): void
    {
        if (!$this->getAccessChecker()->canManageUsers()) {
            throw new Forbidden();
        }

        $rowsPerPage = 10;

        $users = $this->getUserRepository()->find(
            $rowsPerPage,
            $this->getSkipRowsNumber($rowsPerPage)
        );

        $this->renderView([
            'users' => $users,
            'page' => $this->getCurrentPage(),
            'pages' => $this->getTotalPages($this->getUserRepository()->count(), $rowsPerPage),
        ]);
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
