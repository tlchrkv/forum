<?php

declare(strict_types=1);

namespace App\Forum\Comment\Controllers;

use App\Access\Models\AccessChecker\Forum\CommentAccessChecker;
use App\Access\Models\AccessChecker\Forum\TopicAccessChecker;
use App\Access\Models\Forbidden;
use App\Auth\Models\Auth;
use App\Forum\Category\Models\CategoryWriteRepository;
use App\Forum\Comment\Models\CommentRepository;
use App\Forum\Topic\Models\TopicWriteRepository;
use App\SharedKernel\Http\Validation;

final class EditController extends \Phalcon\Mvc\Controller
{
    public function mainAction(string $id): void
    {
        $comment = $this->getCommentRepository()->get($id);
        $topic = $this->getTopicRepository()->get($comment->topic_id);
        $category = $this->getCategoryRepository()->get($topic->category_id);

        if (!$this->getCommentAccessChecker()->canChange($topic->category_id, $comment->created_by)) {
            throw new Forbidden();
        }

        if ($this->request->isPost()) {
            $validation = new Validation([
                'content' => 'required|length_between:1,2000',
            ]);

            $validation->validate($_POST);

            $user = $this->getAuth()->getUserFromSession();

            $comment->edit($_POST['content'], $user->id);

            $this->response->redirect('/' . $category->slug . '/' . $topic->slug);

            return;
        }

        echo $this->view->render(__DIR__ . '/../Views/edit', ['category' => $category, 'topic' => $topic, 'comment' => $comment]);
    }

    private function getAuth(): Auth
    {
        return new Auth();
    }

    private function getCommentAccessChecker(): CommentAccessChecker
    {
        return new CommentAccessChecker();
    }

    private function getCommentRepository(): CommentRepository
    {
        return new CommentRepository();
    }

    private function getCategoryRepository(): CategoryWriteRepository
    {
        return new CategoryWriteRepository();
    }

    private function getTopicRepository(): TopicWriteRepository
    {
        return new TopicWriteRepository();
    }
}
