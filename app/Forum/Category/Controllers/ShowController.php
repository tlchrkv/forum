<?php

declare(strict_types=1);

namespace App\Forum\Category\Controllers;

use App\Forum\Category\Models\CategoryRepository;
use App\Forum\Topic\Models\TopicRepository;
use Ramsey\Uuid\Uuid;

final class ShowController extends \Phalcon\Mvc\Controller
{
    public function mainAction(string $id): void
    {
        $categoryId = Uuid::fromString($id);

        $category = $this->getCategoryRepository()->get($categoryId);
        $topics = $this->getTopicRepository()->findAll();

        echo $this->view->render(
            __DIR__ . '/../Views/show',
            [
                'category' => $category,
                'topics' => $topics,
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
