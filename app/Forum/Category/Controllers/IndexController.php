<?php

declare(strict_types=1);

namespace App\Forum\Category\Controllers;

use App\Forum\Category\Models\CategoryRepository;

final class IndexController extends \Phalcon\Mvc\Controller
{
    public function mainAction(): void
    {
        $categories = $this->getCategoryRepository()->findAll();

        echo $this->view->render(__DIR__ . '/../Views/index', ['categories' => $categories]);
    }

    private function getCategoryRepository(): CategoryRepository
    {
        return new CategoryRepository();
    }
}
