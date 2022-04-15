<?php

declare(strict_types=1);

namespace App\Forum\Category\Controllers;

use App\Forum\Category\Models\CategoryReadRepository;
use App\Forum\Topic\Models\TopicReadRepository;

final class ShowController extends \Phalcon\Mvc\Controller
{
    public function mainAction(string $slug): void
    {
        $page = (int) $this->request->getQuery('page', 'int', 1);

        $category = $this->getCategoryReadRepository()->getBySlug($slug);
        $topics = $this
            ->getTopicReadRepository()
            ->findByCategoryIdOrderedByLastActivity(
                $category['id'],
                10,
                ($page - 1) * 10
            );

        echo $this->view->render(
            __DIR__ . '/../Views/show',
            [
                'category' => $category,
                'topics' => $topics,
                'page' => $page,
                'pages' => ceil($this->getTopicReadRepository()->countByCategoryId($category['id']) / 10),
            ]
        );
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
