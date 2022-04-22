<?php

declare(strict_types=1);

namespace App\Forum\Comment\Models;

use App\SharedKernel\File\Models\FileRepository;
use App\User\Models\UserNotFound;
use App\User\Models\UserRepository;
use Ramsey\Uuid\UuidInterface;

final class Comment extends \Phalcon\Mvc\Model
{
    public function initialize(): void
    {
        $this->setSource('forum_comments');
    }

    public static function add(UuidInterface $id, UuidInterface $topicId, string $content, $userId = null, $replyTo = null): void
    {
        $comment = new self([
            'id' => $id,
            'topic_id' => $topicId,
            'content' => $content,
            'created_at' => (new \DateTime('now'))->format('Y-m-d H:i:s'),
            'created_by' => $userId,
            'reply_to' => $replyTo,
        ]);

        $comment->save();
    }

    public function edit(string $content, $userId): void
    {
        $this->content = $content;
        $this->updated_at = (new \DateTime('now'))->format('Y-m-d H:i:s');
        $this->updated_by = $userId;

        $this->save();
    }

    public function delete(): void
    {
        foreach ((new FileRepository())->findByForumCommentId($this->id) as $file) {
            $file->delete();
        }

        parent::delete();
    }

    public function getAuthorName(): string
    {
        $userRepository = new UserRepository();

        try {
            return $userRepository->get($this->created_by)->name;
        } catch (UserNotFound $e) {
            return 'anonymous';
        }
    }

    public function getReadableDate(): string
    {
        $date = new \DateTime($this->created_at);

        return $date->format('H:i d.m.Y');
    }

    public function getReplyTo(): ?Comment
    {
        if ($this->reply_to === null) {
            return null;
        }

        try {
            return (new CommentWriteRepository())->get($this->reply_to);
        } catch (CommentNotFound $e) {
            return null;
        }
    }
}
