<?php

declare(strict_types=1);

namespace App\Forum\Topic\Models;

final class TopicReadRepository
{
    public function existBySlug(string $slug): bool
    {
        $connection = \Phalcon\DI::getDefault()->getShared('db');
        $query = $connection->query("SELECT count(id) FROM forum_topics WHERE slug = '$slug'");

        return 0 !== (int) $query->fetch()[0];
    }

    public function findByCategoryIdOrderedByLastActivity(string $categoryId, int $count, int $skip = 0): array
    {
        $connection = \Phalcon\DI::getDefault()->getShared('db');

        $sql = <<<SQL
SELECT 
       forum_topics.id,
       forum_topics.name,
       forum_topics.slug,
       COALESCE(comments_count.comments_count, 0) as comments_count,
       users.id as author_id,
       users.name as author_name
FROM forum_topics
    LEFT JOIN (
        SELECT topic_id, max(created_at) as created_at
        FROM forum_comments
        GROUP BY 1
    ) last_comment ON last_comment.topic_id = forum_topics.id
    LEFT JOIN (
        SELECT topic_id, count(id) as comments_count
        FROM forum_comments
        GROUP BY 1 
    ) comments_count ON comments_count.topic_id = forum_topics.id
    LEFT JOIN users ON users.id = forum_topics.created_by
WHERE category_id = '$categoryId'
ORDER BY forum_topics.created_at DESC, last_comment.created_at DESC
LIMIT $count OFFSET $skip
SQL;

        $query = $connection->query($sql);
        $query->setFetchMode(\Phalcon\Db::FETCH_ASSOC);

        return $query->fetchAll();
    }

    public function countByCategoryId(string $categoryId): int
    {
        $connection = \Phalcon\DI::getDefault()->getShared('db');
        $query = $connection->query("SELECT count(id) FROM forum_topics WHERE category_id = '$categoryId'");

        return (int) $query->fetch()[0];
    }

    public function getByCategoryIdAndSlug(string $categoryId, string $slug): array
    {
        $connection = \Phalcon\DI::getDefault()->getShared('db');

        $sql = <<<SQL
SELECT
       forum_topics.id,
       forum_topics.category_id,
       forum_topics.name,
       forum_topics.slug,
       forum_topics.content,
       forum_topics.created_at,
       users.id as author_id,
       users.name as author_name,
       comments_count.comments_count
FROM forum_topics
    LEFT JOIN users ON users.id = forum_topics.created_by
    LEFT JOIN (
        SELECT topic_id, count(id) as comments_count
        FROM forum_comments
        GROUP BY 1 
    ) comments_count ON comments_count.topic_id = forum_topics.id
WHERE category_id = '$categoryId' AND slug = '$slug'
SQL;

        $query = $connection->query($sql);
        $query->setFetchMode(\Phalcon\Db::FETCH_ASSOC);

        return $query->fetch();
    }
}
