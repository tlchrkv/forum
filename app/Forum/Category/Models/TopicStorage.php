<?php

declare(strict_types=1);

namespace App\Forum\Category\Models;

use Ramsey\Uuid\UuidInterface;

interface TopicStorage
{
    public function findLastByCategoryId(UuidInterface $categoryId, int $count): array;

    public function findAll(): array;
}
