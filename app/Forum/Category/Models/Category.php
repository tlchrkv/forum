<?php

declare(strict_types=1);

namespace App\Forum\Category\Models;

use App\Forum\Topic\Models\TopicWriteRepository;
use App\SharedKernel\StringConverter;
use Ramsey\Uuid\UuidInterface;
use Phalcon\Mvc\Model\Resultset;

final class Category extends \Phalcon\Mvc\Model
{
    public function initialize(): void
    {
        $this->setSource('forum_categories');
    }

    public static function add(UuidInterface $id, string $name, UuidInterface $userId): void
    {
        $category = new self([
            'id' => $id,
            'name' => $name,
            'slug' => StringConverter::readableToSlug($name),
            'created_at' => (new \DateTime('now'))->format('Y-m-d H:i:s'),
            'created_by' => $userId,
        ]);

        $category->save();
    }

    public function edit(string $name, UuidInterface $userId): void
    {
        $this->name = $name;
        $this->slug = StringConverter::readableToSlug($name);
        $this->updated_at = (new \DateTime('now'))->format('Y-m-d H:i:s');
        $this->updated_by = $userId;

        $this->save();
    }

    public function getLastTopics(int $count): Resultset
    {
        return $this->getTopicRepository()->findLastByCategoryId($this->id, $count);
    }

    private function getTopicRepository(): TopicWriteRepository
    {
        return new TopicWriteRepository();
    }
}
