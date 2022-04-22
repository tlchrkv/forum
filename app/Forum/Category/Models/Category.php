<?php

declare(strict_types=1);

namespace App\Forum\Category\Models;

use App\Forum\Topic\Models\TopicWriteRepository;
use Phalcon\Mvc\Model\Resultset;

final class Category extends \Phalcon\Mvc\Model
{
    public function initialize(): void
    {
        $this->setSource('forum_categories');
    }

    public static function add($id, string $name, $userId): self
    {
        if ((new CategoryReadRepository())->existByName(ucfirst($name))) {
            throw new CategoryAlreadyExist();
        }

        $category = new self([
            'id' => $id,
            'name' => ucfirst($name),
            'slug' => UniqueSlugGenerator::generate($name),
            'created_at' => (new \DateTime('now'))->format('Y-m-d H:i:s'),
            'created_by' => $userId,
        ]);

        $category->save();

        return $category;
    }

    public function edit(string $name, $userId): void
    {
        $this->name = ucfirst($name);
        $this->slug = UniqueSlugGenerator::generate($name);
        $this->updated_at = (new \DateTime('now'))->format('Y-m-d H:i:s');
        $this->updated_by = $userId;

        $this->save();
    }

    public function delete(): void
    {
        foreach ((new TopicWriteRepository())->findByCategoryId($this->id) as $topic) {
            $topic->delete();
        }

        parent::delete();
    }
}
