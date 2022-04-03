<?php

declare(strict_types=1);

namespace App\Forum\Comment\Controllers;

use App\Access\Models\AccessChecker\Forum\CommentAccessChecker;
use App\Access\Models\Forbidden;
use App\Auth\Models\Auth;
use App\Auth\Models\IsNotAuthenticated;
use App\Forum\Category\Models\CategoryRepository;
use App\Forum\Comment\Models\Comment;
use App\Forum\Topic\Models\TopicRepository;
use App\SharedKernel\Http\Validation;
use Ramsey\Uuid\Uuid;

final class AddController extends \Phalcon\Mvc\Controller
{
    public function mainAction(string $category, string $topic): void
    {
        if (!$this->getCommentAccessChecker()->canAdd()) {
            throw new Forbidden();
        }

        if ($this->request->isPost()) {
            $validation = new Validation([
                'content' => 'required|length_between:1,2000',
            ]);

            $validation->validate($_POST);

            $category = $this->getCategoryRepository()->getBySlug($category);
            $topic = $this->getTopicRepository()->getByCategoryIdAndSlug(
                Uuid::fromString($category->id),
                $topic
            );

            try {
                $userId = $this->getAuth()->getUserFromSession()->id;
            } catch (IsNotAuthenticated $exception) {
                $userId = null;
            }

            Comment::add(
                Uuid::uuid4(),
                Uuid::fromString($topic->id),
                $_POST['content'],
                $userId
            );
        }

        echo $this->view->render(__DIR__ . '/../Views/add');
    }

    private function getCategoryRepository(): CategoryRepository
    {
        return new CategoryRepository();
    }

    private function getTopicRepository(): TopicRepository
    {
        return new TopicRepository();
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
