<?php

declare(strict_types=1);

namespace App\Forum\Category\Adapters;

use App\Forum\Category\Models\Topic;
use App\Forum\Category\Models\TopicStorage;
use App\Forum\Topic\Models\TopicRepository;
use Phalcon\Mvc\Model\Resultset;
use Ramsey\Uuid\UuidInterface;

final class TopicRepositoryAdapter implements TopicStorage
{
    private $topicRepository;

    public function __construct(TopicRepository $topicRepository)
    {
        $this->topicRepository = $topicRepository;
    }

    public function findLastByCategoryId(UuidInterface $categoryId, int $count): array
    {
        $topics = $this->topicRepository->findLastByCategoryId($categoryId, $count)->toArray();

        return array_map(static function (\App\Forum\Topic\Models\Topic $topic): Topic {
            return new Topic($topic->name, $topic->slug);
        }, $topics);
    }

    public function findAll(): array
    {
        $topics = $this->topicRepository->findLastByCategoryId($categoryId, $count)->toArray();

        return array_map(static function (\App\Forum\Topic\Models\Topic $topic): Topic {
            return new Topic($topic->name, $topic->slug);
        }, $topics);
    }
}
