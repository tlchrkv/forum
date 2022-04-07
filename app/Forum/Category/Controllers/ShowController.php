<?php

declare(strict_types=1);

namespace App\Forum\Category\Controllers;

use App\Forum\Category\Models\CategoryRepository;
use App\Forum\Topic\Models\TopicRepository;

final class ShowController extends \Phalcon\Mvc\Controller
{
    public function mainAction(string $slug): void
    {
        $category = $this->getCategoryRepository()->getBySlug($slug);

        $page = (int) $this->request->getQuery('page', 'int', 1);

        $topics = $this->getTopicRepository()->findByCategoryId($category->id, $page, 10);

        echo $this->view->render(
            __DIR__ . '/../Views/show',
            [
                'category' => $category,
                'topics' => $topics,
                'page' => $page,
                'pages' => ceil($this->getTopicRepository()->countByCategoryId($category->id) / 10),
            ]
        );
    }

    private function getCategoryRepository(): CategoryRepository
    {
        return new CategoryRepository();
    }

    private function getTopicRepository(): TopicRepository
    {
        return new TopicRepository();
    }
}
