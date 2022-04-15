<?php

declare(strict_types=1);

namespace App\Forum\Comment\Controllers;

use App\Access\Models\AccessChecker\Forum\CommentAccessChecker;
use App\Access\Models\Forbidden;
use App\Auth\Models\Auth;
use App\Forum\Category\Models\CategoryWriteRepository;
use App\Forum\Comment\Models\Comment;
use App\Forum\Comment\Models\CommentRepository;
use App\Forum\Topic\Models\TopicWriteRepository;
use App\SharedKernel\Http\Validation;
use Ramsey\Uuid\Uuid;

final class AddController extends \Phalcon\Mvc\Controller
{
    public function mainAction(string $categorySlug, string $topicSlug): void
    {
        if (!$this->getCommentAccessChecker()->canAdd()) {
            throw new Forbidden();
        }

        $category = $this->getCategoryRepository()->getBySlug($categorySlug);
        $topic = $this->getTopicRepository()->getByCategoryIdAndSlug(
            Uuid::fromString($category->id),
            $topicSlug
        );

        $replyToId = $this->request->getQuery('reply_to', 'string');
        $replyToId = $replyToId !== '' ? $replyToId : null;
        $replyTo = null;
        if ($replyToId !== null) {
            $replyTo = $this->getCommentRepository()->get($replyToId);
        }

        if ($this->request->isPost()) {
            $validation = new Validation([
                'content' => 'required|length_between:1,2000',
            ]);

            $validation->validate($_POST);

            $user = $this->getAuth()->getUserFromSession();

            Comment::add(
                Uuid::uuid4(),
                Uuid::fromString($topic->id),
                $_POST['content'],
                $user !== null ? $user->id : null,
                isset($_POST['reply_to']) ? $_POST['reply_to'] : null
            );

            $this->response->redirect("/$categorySlug/$topicSlug");

            return;
        }

        echo $this->view->render(
            __DIR__ . '/../Views/add',
            [
                'category' => $category,
                'topic' => $topic,
                'replyTo' => $replyTo,
            ]
        );
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

    private function getCommentAccessChecker(): CommentAccessChecker
    {
        return new CommentAccessChecker();
    }

    private function getAuth(): Auth
    {
        return new Auth();
    }
}
