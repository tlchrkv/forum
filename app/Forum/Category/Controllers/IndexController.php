<?php

declare(strict_types=1);

namespace App\Forum\Category\Controllers;

use App\Forum\Category\Models\CategoryReadRepository;
use App\Forum\Topic\Models\TopicReadRepository;

final class IndexController extends \Phalcon\Mvc\Controller
{
    public function mainAction(): void
    {
        $categories = $this->getCategoryReadRepository()->findNotEmptyOrderedByLastActivity();

        foreach ($categories as &$category) {
            $category['last_topics'] = $this
                ->getTopicReadRepository()
                ->findByCategoryIdOrderedByLastActivity($category['id'], 5);
        }

        echo $this->view->render(__DIR__ . '/../Views/index', ['categories' => $categories]);
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
