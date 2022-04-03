<?php

declare(strict_types=1);

namespace App\Forum\Comment\Controllers;

use App\Auth\Models\Auth;
use App\Forum\Comment\Models\CommentRepository;
use App\SharedKernel\Http\Validation;
use Ramsey\Uuid\Uuid;

final class EditController extends \Phalcon\Mvc\Controller
{
    public function mainAction(string $id): void
    {
        if ($this->request->isPost()) {
            $validation = new Validation([
                'content' => 'required|length_between:1,2000',
            ]);

            $validation->validate($_POST);

            $user = $this->getAuth()->getUserFromSession();

            $this->getCommentRepository()->get(Uuid::fromString($id))
                ->edit($_POST['content'], $user->id);
        }

        echo $this->view->render(__DIR__ . '/../Views/edit');
    }

    private function getAuth(): Auth
    {
        return new Auth();
    }

    private function getCommentRepository(): CommentRepository
    {
        return new CommentRepository();
    }
}
