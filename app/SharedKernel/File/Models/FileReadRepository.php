<?php

declare(strict_types=1);

namespace App\SharedKernel\File\Models;

final class FileReadRepository
{
    public function findByForumTopicId($id): array
    {
        $connection = \Phalcon\DI::getDefault()->getShared('db');

        $sql = "SELECT * FROM files WHERE relation_table = 'forum_topics' AND relation_id = '$id'";

        $query = $connection->query($sql);
        $query->setFetchMode(\Phalcon\Db::FETCH_ASSOC);

        return $query->fetch();
    }

    public function findByForumCommentId($id): array
    {
        $connection = \Phalcon\DI::getDefault()->getShared('db');

        $sql = "SELECT * FROM files WHERE relation_table = 'forum_comments' AND relation_id = '$id'";

        $query = $connection->query($sql);
        $query->setFetchMode(\Phalcon\Db::FETCH_ASSOC);

        return $query->fetch();
    }
}
