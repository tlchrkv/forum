<?php

declare(strict_types=1);

namespace App\Forum\Category\Controllers;

use App\Access\Models\AccessChecker\Forum\CategoryAccessChecker;
use App\Access\Models\Forbidden;
use App\Forum\Category\Models\CategoryWriteRepository;
use Ramsey\Uuid\Uuid;

final class DeleteController extends \Phalcon\Mvc\Controller
{
    public function mainAction(string $id): void
    {
        if (!$this->getCategoryAccessChecker()->canDelete()) {
            throw new Forbidden();
        }

        $category = $this->getCategoryRepository()->get(Uuid::fromString($id));
        $category->delete();

        $this->response->redirect('/');
    }

    private function getCategoryRepository(): CategoryWriteRepository
    {
        return new CategoryWriteRepository();
    }

    private function getCategoryAccessChecker(): CategoryAccessChecker
    {
        return new CategoryAccessChecker();
    }
}
