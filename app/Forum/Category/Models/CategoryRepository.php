<?php

declare(strict_types=1);

namespace App\Forum\Category\Models;

use Phalcon\Mvc\Model\Resultset;
use Ramsey\Uuid\UuidInterface;

final class CategoryRepository
{
    public function get($id): Category
    {
        $category = Category::findFirst("id = '$id'");

        if ($category === false) {
            throw new CategoryNotFound();
        }

        return $category;
    }

    public function getBySlug(string $slug): Category
    {
        $category = Category::findFirst("slug = '$slug'");

        if ($category === false) {
            throw new CategoryNotFound();
        }

        return $category;
    }

    public function findAll(): Resultset
    {
        return Category::find();
    }
}
