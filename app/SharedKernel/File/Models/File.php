<?php

declare(strict_types=1);

namespace App\SharedKernel\File\Models;

final class File extends \Phalcon\Mvc\Model
{
    public function initialize(): void
    {
        $this->setSource('files');
    }

    public static function addForForumTopic($id, $forumTopicId, string $tmpName, string $originalName): void
    {
        $mimeType = self::extractMimeType($tmpName);
        $placement = self::getConfig()['files_dir'] . '/' . $id;

        $file = new File([
            'id' => $id,
            'name' => $originalName,
            'mime_type' => $mimeType,
            'placement' => $placement,
            'created_at' => (new \DateTime('now'))->format('Y-m-d H:i:s'),
            'relation_table' => 'forum_topics',
            'relation_id' => $forumTopicId,
        ]);

        move_uploaded_file($tmpName, $placement);

        $file->save();
    }

    public static function addForForumComment($id, $forumCommentId, string $tmpName, string $originalName): void
    {
        $mimeType = self::extractMimeType($tmpName);
        $placement = self::getConfig()['files_dir'] . '/' . $id;

        $file = new File([
            'id' => $id,
            'name' => $originalName,
            'mime_type' => $mimeType,
            'placement' => $placement,
            'created_at' => (new \DateTime('now'))->format('Y-m-d H:i:s'),
            'relation_table' => 'forum_comments',
            'relation_id' => $forumCommentId,
        ]);

        move_uploaded_file($tmpName, $placement);

        $file->save();
    }

    private static function getConfig(): array
    {
        return include __DIR__ . '/../config.php';
    }

    public function fullDelete(): void
    {
        unlink($this->placement);
        $this->delete();
    }

    public function getImageBase64Content(): string
    {
        if (!self::isImageMimeType($this->mime_type)) {
            return '';
        }

        $data = file_get_contents($this->placement);
        $type = pathinfo($this->placement, PATHINFO_EXTENSION);

        return 'data:image/' . $type . ';base64,' . base64_encode($data);
    }

    public static function isImageMimeType(string $mimeType): bool
    {
        return str_contains($mimeType, 'image/');
    }

    public static function extractMimeType(string $placement): string
    {
        return (new \finfo(FILEINFO_MIME_TYPE))->file($placement);
    }
}
