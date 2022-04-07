<?php

declare(strict_types=1);

namespace App\Forum\Topic\Models;

use Phalcon\Mvc\Model\Resultset;
use Ramsey\Uuid\UuidInterface;

final class TopicRepository
{
    public function get($id): Topic
    {
        $topic = Topic::findFirst("id = '$id'");

        if ($topic === false) {
            throw new TopicNotFound();
        }

        return $topic;
    }

    public function getByCategoryIdAndSlug(UuidInterface $categoryId, string $slug): Topic
    {
        $topic = Topic::findFirst("category_id = '$categoryId' and slug = '$slug'");

        if ($topic === false) {
            throw new TopicNotFound();
        }

        return $topic;
    }

    public function findAll(): Resultset
    {
        return Topic::find();
    }

    public function countByCategoryId($categoryId): int
    {
        return Topic::count([
            'conditions' => 'category_id = :category_id:',
            'bind' => [
                'category_id' => $categoryId,
            ],
        ]);
    }

    public function findByCategoryId($categoryId, int $page, int $limit): Resultset
    {
        return Topic::find([
            'conditions' => 'category_id = :category_id:',
            'bind' => [
                'category_id' => $categoryId,
            ],
            'order' => 'created_at desc',
            'limit' => $limit,
            'offset' => ($page - 1) * $limit,
        ]);
    }

    public function findLastByCategoryId($categoryId, $count): Resultset
    {
        return Topic::find([
            'conditions' => 'category_id = :category_id:',
            'bind' => [
                'category_id' => $categoryId,
            ],
            'order' => 'created_at desc',
            'limit' => $count,
        ]);
    }
}
