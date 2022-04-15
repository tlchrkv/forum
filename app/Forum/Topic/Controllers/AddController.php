<?php

declare(strict_types=1);

namespace App\Forum\Topic\Controllers;

use App\Access\Models\AccessChecker\Forum\TopicAccessChecker;
use App\Access\Models\Forbidden;
use App\Auth\Models\Auth;
use App\Forum\Category\Models\CategoryWriteRepository;
use App\Forum\Topic\Models\Topic;
use App\SharedKernel\Http\Validation;
use Ramsey\Uuid\Uuid;

final class AddController extends \Phalcon\Mvc\Controller
{
    public function mainAction(string $categorySlug): void
    {
        if (!$this->getTopicAccessChecker()->canAdd()) {
            throw new Forbidden();
        }

        $category = $this->getCategoryRepository()->getBySlug($categorySlug);

        if ($this->request->isPost()) {
            $validation = new Validation([
                'name' => 'required|length_between:1,64',
                'content' => 'required|length_between:1,2000',
            ]);

            $validation->validate($_POST);

            $user = $this->getAuth()->getUserFromSession();

            $topic = Topic::add(
                Uuid::uuid4(),
                Uuid::fromString($category->id),
                $_POST['name'],
                $_POST['content'],
                Uuid::fromString($user->id)
            );

            $this->response->redirect('/' . $categorySlug . '/' . $topic->slug);

            return;
        }

        echo $this->view->render(__DIR__ . '/../Views/add', ['category' => $category]);
    }

    private function getTopicAccessChecker(): TopicAccessChecker
    {
        return new TopicAccessChecker();
    }

    private function getAuth(): Auth
    {
        return new Auth();
    }

    private function getCategoryRepository(): CategoryWriteRepository
    {
        return new CategoryWriteRepository();
    }
}
