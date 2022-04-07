<?php

declare(strict_types=1);

namespace App\Forum\Topic\Controllers;

use App\Forum\Category\Models\CategoryRepository;
use App\Forum\Comment\Models\CommentRepository;
use App\Forum\Topic\Models\TopicRepository;
use App\SharedKernel\TimeSorting;
use Ramsey\Uuid\Uuid;

final class ShowController extends \Phalcon\Mvc\Controller
{
    public function mainAction(string $categorySlug, string $slug): void
    {
        $category = $this->getCategoryRepository()->getBySlug($categorySlug);
        $topic = $this->getTopicRepository()->getByCategoryIdAndSlug(Uuid::fromString($category->id), $slug);

        $page = (int) $this->request->getQuery('page', 'int', 1);

        $comments = $this->getCommentRepository()
            ->findByTopicId(
                Uuid::fromString($topic->id),
                TimeSorting::newest(),
                $page,
                5
            );

        echo $this->view->render(
            __DIR__ . '/../Views/show',
            [
                'category' => $category,
                'topic' => $topic,
                'comments' => $comments,
                'categorySlug' => $categorySlug,
                'topicSlug' => $slug,
                'page' => $page,
                'pages' => ceil($this->getCommentRepository()->countByTopicId(Uuid::fromString($topic->id)) / 5),
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

    private function getCommentRepository(): CommentRepository
    {
        return new CommentRepository();
    }
}
