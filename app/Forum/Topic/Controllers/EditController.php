<?php

declare(strict_types=1);

namespace App\Forum\Topic\Controllers;

use App\Access\Models\AccessChecker\Forum\TopicAccessChecker;
use App\Access\Models\Forbidden;
use App\Auth\Models\Auth;
use App\Forum\Category\Models\CategoryWriteRepository;
use App\Forum\Topic\Models\TopicWriteRepository;
use App\SharedKernel\Http\Validation;

final class EditController extends \Phalcon\Mvc\Controller
{
    public function mainAction(string $id): void
    {
        $topic = $this->getTopicRepository()->get($id);
        $category = $this->getCategoryRepository()->get($topic->category_id);

        if (!$this->getTopicAccessChecker()->canChange($topic->category_id, $topic->created_by)) {
            throw new Forbidden();
        }

        if ($this->request->isPost()) {
            $validation = new Validation([
                'name' => 'required|length_between:1,64',
                'content' => 'required|length_between:1,2000',
            ]);

            $validation->validate($_POST);

            $user = $this->getAuth()->getUserFromSession();

            $topic->edit(
                $_POST['name'],
                $_POST['content'],
                $user->id
            );

            $this->response->redirect('/' . $category->slug . '/' . $topic->slug);

            return;
        }

        echo $this->view->render(__DIR__ . '/../Views/edit', ['category' => $category, 'topic' => $topic]);
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

    private function getTopicRepository(): TopicWriteRepository
    {
        return new TopicWriteRepository();
    }
}
