<?php

declare(strict_types=1);

namespace App\Forum\Category\Controllers;

use App\Forum\Category\Models\CategoryReadRepository;
use App\Forum\Topic\Models\TopicReadRepository;
use App\SharedKernel\Controllers\ModuleViewRender;

final class IndexController extends \Phalcon\Mvc\Controller
{
    use ModuleViewRender;

    public function mainAction(): void
    {
        $topicsPerCategory = 5;
        $categories = $this->getCategoryReadRepository()->findNotEmptyOrderedByLastActivity();

        foreach ($categories as &$category) {
            $category['last_topics'] = $this
                ->getTopicReadRepository()
                ->findByCategoryIdOrderedByLastActivity($category['id'], $topicsPerCategory);
        }

        $this->renderView(['categories' => $categories, 'topicsPerCategory' => $topicsPerCategory]);
    }

    private function getCategoryReadRepository(): CategoryReadRepository
    {
        return new CategoryReadRepository();
    }

    private function getTopicReadRepository(): TopicReadRepository
    {
        return new TopicReadRepository();
    }
}
