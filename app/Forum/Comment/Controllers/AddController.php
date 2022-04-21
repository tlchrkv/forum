<?php

declare(strict_types=1);

namespace App\Forum\Comment\Controllers;

use App\Access\Models\AccessChecker\Forum\CommentAccessChecker;
use App\Access\Models\Forbidden;
use App\Auth\Models\Auth;
use App\Forum\Category\Models\CategoryWriteRepository;
use App\Forum\Comment\Models\Comment;
use App\Forum\Comment\Models\CommentWriteRepository;
use App\Forum\Topic\Models\TopicWriteRepository;
use App\SharedKernel\Controllers\ModuleViewRender;
use App\SharedKernel\File\Models\File;
use App\SharedKernel\Http\RequestFilesNormalizer;
use App\SharedKernel\Http\Validation;
use Ramsey\Uuid\Uuid;

final class AddController extends \Phalcon\Mvc\Controller
{
    use ModuleViewRender;

    public function mainAction(string $categorySlug, string $topicSlug): void
    {
        if (!$this->getCommentAccessChecker()->canAdd()) {
            throw new Forbidden();
        }

        $category = $this->getCategoryRepository()->getBySlug($categorySlug);
        $topic = $this->getTopicRepository()->getByCategoryIdAndSlug(
            Uuid::fromString($category->id),
            $topicSlug
        );

        $replyToId = $this->request->getQuery('reply_to', 'string');
        $replyToId = $replyToId !== '' ? $replyToId : null;
        $replyTo = null;
        if ($replyToId !== null) {
            $replyTo = $this->getCommentRepository()->get($replyToId);
        }

        if ($this->request->isPost()) {
            try {
                $validation = new Validation([
                    'content' => 'required|length_between:1,2000',
                ]);

                $validation->validate($_POST);

                $images = [];
                if ($_FILES['images']['error'][0] !== 4) {
                    $images = RequestFilesNormalizer::normalize($_FILES['images']);

                    $maxTotalSize = 1024 * 1024 * 4;
                    $totalSize = 0;

                    foreach ($images as $image) {
                        if (!File::isImageMimeType(File::extractMimeType($image['tmp_name']))) {
                            throw new \InvalidArgumentException('You can attach only images');
                        }

                        $totalSize = $image['size'];
                    }

                    if ($totalSize > $maxTotalSize) {
                        throw new \InvalidArgumentException('Total size of all images must be less than 4MB');
                    }
                }

                $user = $this->getAuth()->getUserFromSession();
                $commentId = Uuid::uuid4();

                Comment::add(
                    $commentId,
                    Uuid::fromString($topic->id),
                    $_POST['content'],
                    $user !== null ? $user->id : null,
                    isset($_POST['reply_to']) ? $_POST['reply_to'] : null
                );

                foreach ($images as $image) {
                    File::addForForumComment(
                        Uuid::uuid4(),
                        $commentId,
                        $image['tmp_name'],
                        $image['name']
                    );
                }

                $this->response->redirect("/$categorySlug/$topicSlug");

                return;
            } catch (\InvalidArgumentException $e) {
                $this->renderView([
                    'category' => $category,
                    'topic' => $topic,
                    'replyTo' => $replyTo,
                    'error' => $e->getMessage(),
                ]);

                return;
            }
        }

        $this->renderView([
            'category' => $category,
            'topic' => $topic,
            'replyTo' => $replyTo,
        ]);
    }

    private function getCommentRepository(): CommentWriteRepository
    {
        return new CommentWriteRepository();
    }

    private function getCategoryRepository(): CategoryWriteRepository
    {
        return new CategoryWriteRepository();
    }

    private function getTopicRepository(): TopicWriteRepository
    {
        return new TopicWriteRepository();
    }

    private function getCommentAccessChecker(): CommentAccessChecker
    {
        return new CommentAccessChecker();
    }

    private function getAuth(): Auth
    {
        return new Auth();
    }
}
