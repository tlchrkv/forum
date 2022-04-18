<?php

declare(strict_types=1);

namespace App\Forum\Topic\Controllers;

use App\Forum\Category\Models\CategoryReadRepository;
use App\Forum\Comment\Models\CommentReadRepository;
use App\Forum\Topic\Models\TopicReadRepository;

final class ShowController extends \Phalcon\Mvc\Controller
{
    public function mainAction(string $categorySlug, string $slug): void
    {
        $page = (int) $this->request->getQuery('page', 'int', 1);

        $category = $this->getCategoryReadRepository()->getBySlug($categorySlug);
        $topic = $this->getTopicReadRepository()->getByCategoryIdAndSlug($category['id'], $slug);

        $comments = $this->getCommentReadRepository()
            ->findByTopicId(
                $topic['id'],
                10,
                ($page - 1) * 10
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
                'pages' => ceil($this->getCommentReadRepository()->countByTopicId($topic['id']) / 10),
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

    private function getCommentReadRepository(): CommentReadRepository
    {
        return new CommentReadRepository();
    }
}
