<?php

declare(strict_types=1);

namespace App\Forum\Category\Controllers;

use App\Forum\Category\Models\CategoryRepository;
use Ramsey\Uuid\Uuid;

final class DeleteController extends \Phalcon\Mvc\Controller
{
    public function mainAction(string $id): void
    {
        $category = $this->getCategoryRepository()->get(Uuid::fromString($id));
        $category->delete();
    }

    private function getCategoryRepository(): CategoryRepository
    {
        return di(CategoryRepository::class);
    }
}
