<?php

declare(strict_types=1);

namespace App\Forum\Comment\Controllers;

use App\Forum\Comment\Models\CommentRepository;
use Ramsey\Uuid\Uuid;

final class DeleteController extends \Phalcon\Mvc\Controller
{
    public function mainAction(string $id): void
    {
        $this->getCommentRepository()->get(Uuid::fromString($id))->delete();
    }

    private function getCommentRepository(): CommentRepository
    {
        return new CommentRepository();
    }
}
