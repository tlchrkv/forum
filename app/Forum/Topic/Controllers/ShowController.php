<?php

declare(strict_types=1);

namespace App\Forum\Topic\Controllers;

use App\Forum\Category\Models\CategoryReadRepository;
use App\Forum\Comment\Models\CommentRepository;
use App\Forum\Topic\Models\TopicReadRepository;
use App\SharedKernel\TimeSorting;
use Ramsey\Uuid\Uuid;

final class ShowController extends \Phalcon\Mvc\Controller
{
    public function mainAction(string $categorySlug, string $slug): void
    {
        $page = (int) $this->request->getQuery('page', 'int', 1);

        $category = $this->getCategoryReadRepository()->getBySlug($categorySlug);
        $topic = $this->getTopicReadRepository()->getByCategoryIdAndSlug($category['id'], $slug);

        $comments = $this->getCommentRepository()
            ->findByTopicId(
                Uuid::fromString($topic['id']),
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
                'pages' => ceil($this->getCommentRepository()->countByTopicId(Uuid::fromString($topic['id'])) / 5),
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

    private function getCommentRepository(): CommentRepository
    {
        return new CommentRepository();
    }
}
