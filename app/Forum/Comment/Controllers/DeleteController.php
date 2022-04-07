<?php

declare(strict_types=1);

namespace App\Forum\Comment\Controllers;

use App\Access\Models\AccessChecker\Forum\CommentAccessChecker;
use App\Access\Models\Forbidden;
use App\Forum\Category\Models\CategoryRepository;
use App\Forum\Comment\Models\CommentRepository;
use App\Forum\Topic\Models\TopicRepository;

final class DeleteController extends \Phalcon\Mvc\Controller
{
    public function mainAction(string $id): void
    {
        $comment = $this->getCommentRepository()->get($id);
        $topic = $this->getTopicRepository()->get($comment->topic_id);
        $category = $this->getCategoryRepository()->get($topic->category_id);

        if (!$this->getCommentAccessChecker()->canDelete($topic->category_id, $comment->created_by)) {
            throw new Forbidden();
        }

        $this->getCommentRepository()->get($id)->delete();

        $this->response->redirect('/' . $category->slug . '/' . $topic->slug);
    }

    private function getCommentAccessChecker(): CommentAccessChecker
    {
        return new CommentAccessChecker();
    }

    private function getTopicRepository(): TopicRepository
    {
        return new TopicRepository();
    }

    private function getCommentRepository(): CommentRepository
    {
        return new CommentRepository();
    }

    private function getCategoryRepository(): CategoryRepository
    {
        return new CategoryRepository();
    }
}
