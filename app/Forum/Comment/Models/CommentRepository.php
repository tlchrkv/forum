<?php

declare(strict_types=1);

namespace App\Forum\Comment\Models;

use App\SharedKernel\TimeSorting;
use Phalcon\Mvc\Model\Resultset;
use Ramsey\Uuid\UuidInterface;

final class CommentRepository
{
    public function get($id): Comment
    {
        $comment = Comment::findFirst("id = '$id'");

        if ($comment === false) {
            throw new CommentNotFound();
        }

        return $comment;
    }

    public function countByTopicId(UuidInterface $topicId): int
    {
        return Comment::count("topic_id = '$topicId'");
    }

    public function findByTopicId(UuidInterface $topicId, TimeSorting $timeSorting, int $page, int $limit): Resultset
    {
        $sortingDirection = $timeSorting == TimeSorting::newest() ? 'desc' : 'asc';

        return Comment::find([
            "topic_id = '$topicId'",
            'order' => 'created_at ' . $sortingDirection,
            'limit' => $limit,
            'offset' => ($page - 1) * $limit,
        ]);
    }
}
