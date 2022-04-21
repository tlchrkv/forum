<?php

declare(strict_types=1);

namespace App\SharedKernel\File\Models;

final class FileRepository
{
    public function get($id): File
    {
        $file = File::findFirst("id = '$id'");

        if ($file === false) {
            throw new FileNotFound();
        }

        return $file;
    }

    public function findByForumTopicId($id)
    {
        return File::find("relation_table = 'forum_topics' AND relation_id = '$id'");
    }

    public function findByForumCommentId($id)
    {
        return File::find("relation_table = 'forum_comments' AND relation_id = '$id'");
    }

    public function findByForumCommentsIds(array $ids)
    {
        $idsRow = '\'' . implode('\', \'', $ids) . '\'';

        return File::find("relation_table = 'forum_comments' AND relation_id IN ($idsRow)");
    }
}
