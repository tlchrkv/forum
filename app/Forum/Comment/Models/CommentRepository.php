<?php

declare(strict_types=1);

namespace App\Forum\Comment\Models;

use App\SharedKernel\TimeSorting;
use Phalcon\Mvc\Model\Resultset;
use Ramsey\Uuid\UuidInterface;

final class CommentRepository
{
    public function get(UuidInterface $id): Comment
    {
        $comment = Comment::findFirst($id);

        if ($comment === false) {
            throw new CommentNotFound();
        }

        return $comment;
    }

    public function findByTopicId(UuidInterface $topicId, TimeSorting $timeSorting): Resultset
    {
        return Comment::find([
            'conditions' => 'topic_id = :topic_id:',
            'bind' => [
                'topic_id' => $topicId,
            ],
            'order' => 'created_at ' . $timeSorting == TimeSorting::newest() ? 'desc' : 'asc',
        ]);
    }
}
