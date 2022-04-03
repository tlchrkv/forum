<?php

declare(strict_types=1);

namespace App\Forum\Category\Models;

use Phalcon\Mvc\Model\Resultset;
use Ramsey\Uuid\UuidInterface;

final class CategoryRepository
{
    public function get(UuidInterface $id): Category
    {
        $category = Category::findFirst($id);

        if ($category === null) {
            throw new CategoryNotFound();
        }

        return $category;
    }

    public function getBySlug(string $slug): Category
    {
        $category = Category::findFirst("slug = '$slug'");

        if ($category === null) {
            throw new CategoryNotFound();
        }

        return $category;
    }

    public function findAll(): Resultset
    {
        return Category::find();
    }
}
