<?php

declare(strict_types=1);

namespace App\Forum\Topic\Models;

use App\SharedKernel\StringConverter;
use Ramsey\Uuid\UuidInterface;

final class Topic extends \Phalcon\Mvc\Model
{
    public function initialize(): void
    {
        $this->setSource('forum_topics');
    }

    public static function add(UuidInterface $id, UuidInterface $categoryId, string $name, string $content, UuidInterface $userId): void
    {
        $topic = new Topic([
            'id' => $id,
            'category_id' => $categoryId,
            'name' => $name,
            'slug' => StringConverter::readableToSlug($name),
            'content' => $content,
            'created_at' => (new \DateTime('now'))->format('Y-m-d H:i:s'),
            'created_by' => $userId,
        ]);

        $topic->save();
    }

    public function edit(UuidInterface $categoryId, string $name, string $content, UuidInterface $userId): void
    {
        $this->category_id = $categoryId;
        $this->name = $name;
        $this->slug = StringConverter::readableToSlug($name);
        $this->content = $content;
        $this->updated_at = (new \DateTime('now'))->format('Y-m-d H:i:s');
        $this->updated_by = $userId;

        $this->save();
    }
}
