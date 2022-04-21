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

    public static function add($id, $categoryId, string $name, string $content, $userId): self
    {
        $topic = new Topic([
            'id' => $id,
            'category_id' => $categoryId,
            'name' => $name,
            'slug' => UniqueSlugGenerator::generate($name),
            'content' => $content,
            'created_at' => (new \DateTime('now'))->format('Y-m-d H:i:s'),
            'created_by' => $userId,
        ]);

        $topic->save();

        return $topic;
    }

    public function edit(string $name, string $content, $userId): void
    {
        $this->name = $name;
        $this->slug = UniqueSlugGenerator::generate($name);
        $this->content = $content;
        $this->updated_at = (new \DateTime('now'))->format('Y-m-d H:i:s');
        $this->updated_by = $userId;

        $this->save();
    }
}
