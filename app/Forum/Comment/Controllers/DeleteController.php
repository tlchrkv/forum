<?php

declare(strict_types=1);

namespace App\Forum\Comment\Controllers;

use App\Access\Models\AccessChecker\Forum\CommentAccessChecker;
use App\Access\Models\Forbidden;
use App\Forum\Category\Models\CategoryWriteRepository;
use App\Forum\Comment\Models\CommentWriteRepository;
use App\Forum\Topic\Models\TopicWriteRepository;

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

    private function getTopicRepository(): TopicWriteRepository
    {
        return new TopicWriteRepository();
    }

    private function getCommentRepository(): CommentWriteRepository
    {
        return new CommentWriteRepository();
    }

    private function getCategoryRepository(): CategoryWriteRepository
    {
        return new CategoryWriteRepository();
    }
}
