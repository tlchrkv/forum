<?php

declare(strict_types=1);

namespace App\Access\Adapters;

use App\Access\Models\AccessChecker\Forum\ModerateCategory\CategoryStorage;
use App\Forum\Category\Models\CategoryRepository;
use Phalcon\Mvc\Model\Resultset;

final class CategoryRepositoryAdapter implements CategoryStorage
{
    private $categoryRepository;

    public function __construct(CategoryRepository $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
    }

    public function findAll(): Resultset
    {
        return $this->categoryRepository->findAll();
    }
}
