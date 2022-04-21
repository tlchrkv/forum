<?php

declare(strict_types=1);

namespace App\Forum\Category\Controllers;

use App\Forum\Category\Models\CategoryReadRepository;
use App\Forum\Topic\Models\TopicReadRepository;
use App\SharedKernel\Controllers\ModuleViewRender;
use App\SharedKernel\Controllers\Pagination;

final class ShowController extends \Phalcon\Mvc\Controller
{
    use ModuleViewRender;
    use Pagination;

    public function mainAction(string $slug): void
    {
        $rowsPerPage = 10;
        $page = $this->getCurrentPage();

        $category = $this->getCategoryReadRepository()->getBySlug($slug);

        $topics = $this
            ->getTopicReadRepository()
            ->findByCategoryIdOrderedByLastActivity(
                $category['id'],
                $rowsPerPage,
                $this->getSkipRowsNumber($rowsPerPage)
            );
        $topicsCount = $this->getTopicReadRepository()->countByCategoryId($category['id']);

        $this->renderView([
            'category' => $category,
            'topics' => $topics,
            'page' => $page,
            'pages' => $this->getTotalPages($topicsCount, $rowsPerPage),
        ]);
    }

    private function getCategoryReadRepository(): CategoryReadRepository
    {
        return new CategoryReadRepository();
    }

    private function getTopicReadRepository(): TopicReadRepository
    {
        return new TopicReadRepository();
    }
}
