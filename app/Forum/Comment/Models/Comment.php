<?php

declare(strict_types=1);

namespace App\Forum\Comment\Models;

use Ramsey\Uuid\UuidInterface;

final class Comment extends \Phalcon\Mvc\Model
{
    public function initialize(): void
    {
        $this->setSource('forum_comments');
    }

    public static function add(UuidInterface $id, UuidInterface $topicId, string $content, UuidInterface $userId = null): void
    {
        $comment = new self([
            'id' => $id,
            'topic_id' => $topicId,
            'content' => $content,
            'created_at' => (new \DateTime('now'))->format('Y-m-d H:i:s'),
            'created_by' => $userId,
        ]);

        $comment->save();
    }

    public function edit(string $content, UuidInterface $userId): void
    {
        $this->content = $content;
        $this->updated_at = (new \DateTime('now'))->format('Y-m-d H:i:s');
        $this->updated_by = $userId;

        $this->save();
    }
}
