<?php

declare(strict_types=1);

namespace App\Forum\Topic\Controllers;

use App\Access\Models\AccessChecker\Forum\TopicAccessChecker;
use App\Access\Models\Forbidden;
use App\Forum\Category\Models\CategoryWriteRepository;
use App\Forum\Topic\Models\TopicWriteRepository;

final class DeleteController extends \Phalcon\Mvc\Controller
{
    public function mainAction(string $id): void
    {
        $topic = $this->getTopicRepository()->get($id);
        $category = $this->getCategoryRepository()->get($topic->category_id);

        if (!$this->getTopicAccessChecker()->canDelete($topic->category_id, $topic->created_by)) {
            throw new Forbidden();
        }

        $topic = $this->getTopicRepository()->get($id);
        $topic->delete();

        $this->response->redirect('/' . $category->slug);
    }

    private function getTopicAccessChecker(): TopicAccessChecker
    {
        return new TopicAccessChecker();
    }

    private function getTopicRepository(): TopicWriteRepository
    {
        return new TopicWriteRepository();
    }

    private function getCategoryRepository(): CategoryWriteRepository
    {
        return new CategoryWriteRepository();
    }
}
