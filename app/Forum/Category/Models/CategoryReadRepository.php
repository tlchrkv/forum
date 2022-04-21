<?php

declare(strict_types=1);

namespace App\Forum\Category\Models;

final class CategoryReadRepository
{
    public function existByName(string $name): bool
    {
        $connection = \Phalcon\DI::getDefault()->getShared('db');
        $query = $connection->query("SELECT count(id) FROM forum_categories WHERE name = '$name'");

        return 0 !== (int) $query->fetch()[0];
    }

    public function existBySlug(string $slug): bool
    {
        $connection = \Phalcon\DI::getDefault()->getShared('db');
        $query = $connection->query("SELECT count(id) FROM forum_categories WHERE slug = '$slug'");

        return 0 !== (int) $query->fetch()[0];
    }

    public function getBySlug(string $slug): array
    {
        $connection = \Phalcon\DI::getDefault()->getShared('db');

        $sql = "SELECT id, name, slug FROM forum_categories WHERE slug = '$slug'";

        $query = $connection->query($sql);
        $query->setFetchMode(\Phalcon\Db::FETCH_ASSOC);

        $result = $query->fetch();

        if ($result === false) {
            throw new CategoryNotFound();
        }

        return $result;
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
    LEFT JOIN (
        SELECT category_id, count(id) as topics_count
        FROM forum_topics
        GROUP BY 1 
    ) topics_count ON topics_count.category_id = forum_categories.id
ORDER BY last_topic.created_at DESC NULLS LAST, last_comment.created_at DESC NULLS LAST
SQL;

        $query = $connection->query($sql);
        $query->setFetchMode(\Phalcon\Db::FETCH_ASSOC);

        return $query->fetchAll();
    }
}
