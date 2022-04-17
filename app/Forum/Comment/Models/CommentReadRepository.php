<?php

declare(strict_types=1);

namespace App\Forum\Comment\Models;

final class CommentReadRepository
{
    public function findByTopicId(string $topicId, int $count, int $skip = 0): array
    {
        $connection = \Phalcon\DI::getDefault()->getShared('db');

        $sql = <<<SQL
SELECT
       forum_comments.id,
       forum_comments.content,
       coalesce(users.name, 'anonymous') as author_name,
       forum_comments.created_at,
       forum_comments.reply_to as reply_to_id,
       reply_to.content as reply_to_content
FROM forum_comments
    LEFT JOIN forum_comments as reply_to ON reply_to.id = forum_comments.reply_to
    LEFT JOIN users ON users.id = forum_comments.created_by
WHERE forum_comments.topic_id = '$topicId'
ORDER BY forum_comments.created_at DESC
LIMIT $count OFFSET $skip
SQL;

        $query = $connection->query($sql);
        $query->setFetchMode(\Phalcon\Db::FETCH_ASSOC);

        return $query->fetchAll();
    }

    public function countByTopicId(string $topicId): int
    {
        $connection = \Phalcon\DI::getDefault()->getShared('db');
        $query = $connection->query("SELECT count(id) FROM forum_comments WHERE topic_id = '$topicId'");

        return (int) $query->fetch()[0];
    }
}
