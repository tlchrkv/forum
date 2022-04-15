<?php

declare(strict_types=1);

namespace App\Forum\Category\Models;

final class CategoryReadRepository
{
    public function getBySlug(string $slug): array
    {
        $connection = \Phalcon\DI::getDefault()->getShared('db');

        $sql = "SELECT id, name, slug FROM forum_categories WHERE slug = '$slug'";

        $query = $connection->query($sql);
        $query->setFetchMode(\Phalcon\Db::FETCH_ASSOC);

        return $query->fetch();
    }

    public function findNotEmptyOrderedByLastActivity(): array
    {
        $connection = \Phalcon\DI::getDefault()->getShared('db');

        $sql = <<<SQL
SELECT id, name, slug, topics_count.topics_count
FROM forum_categories
    LEFT JOIN (
        SELECT category_id, max(created_at) as created_at
        FROM forum_topics
        GROUP BY 1
    ) last_topic ON last_topic.category_id = forum_categories.id
    LEFT JOIN (
        SELECT ft.category_id, max(fc.created_at) as created_at
        FROM forum_comments fc
        INNER JOIN forum_topics ft ON ft.id = fc.topic_id
        GROUP BY 1
    ) last_comment ON last_comment.category_id = forum_categories.id
    INNER JOIN (
        SELECT category_id, count(id) as topics_count
        FROM forum_topics
        GROUP BY 1 
    ) topics_count ON topics_count.category_id = forum_categories.id
WHERE last_topic.created_at IS NOT NULL
ORDER BY last_topic.created_at DESC, last_comment.created_at DESC
SQL;

        $query = $connection->query($sql);
        $query->setFetchMode(\Phalcon\Db::FETCH_ASSOC);

        return $query->fetchAll();
    }
}
