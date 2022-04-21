<?php

declare(strict_types=1);

namespace App\Forum\Topic\Controllers;

use App\Forum\Category\Models\CategoryReadRepository;
use App\Forum\Comment\Models\CommentReadRepository;
use App\Forum\Topic\Models\TopicReadRepository;
use App\SharedKernel\Controllers\ModuleViewRender;
use App\SharedKernel\File\Models\FileRepository;

final class ShowController extends \Phalcon\Mvc\Controller
{
    use ModuleViewRender;

    public function mainAction(string $categorySlug, string $slug): void
    {
        $page = (int) $this->request->getQuery('page', 'int', 1);

        $category = $this->getCategoryReadRepository()->getBySlug($categorySlug);
        $topic = $this->getTopicReadRepository()->getByCategoryIdAndSlug($category['id'], $slug);

        $comments = $this->getCommentReadRepository()
            ->findByTopicId(
                $topic['id'],
                10,
                ($page - 1) * 10
            );

        $commentIds = [];
        foreach ($comments as $comment) {
            $commentIds[] = $comment['id'];
        }

        if ($commentIds !== []) {
            $viewableCommentImages = [];
            $commentImages = $this->getFileRepository()->findByForumCommentsIds($commentIds);
            foreach ($commentImages as $commentImage) {
                $viewableCommentImages[$commentImage->relation_id][] = [
                    'id' => $commentImage->id,
                    'content' => $commentImage->getImageBase64Content(),
                ];
            }
        }

        $this->renderView([
            'category' => $category,
            'topic' => $topic,
            'images' => $this->getFileRepository()->findByForumTopicId($topic['id']),
            'comments' => $comments,
            'commentImages' => $viewableCommentImages ?? [],
            'categorySlug' => $categorySlug,
            'topicSlug' => $slug,
            'page' => $page,
            'pages' => ceil($this->getCommentReadRepository()->countByTopicId($topic['id']) / 10),
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

    private function getFileRepository(): FileRepository
    {
        return new FileRepository();
    }

    private function getCommentReadRepository(): CommentReadRepository
    {
        return new CommentReadRepository();
    }
}
