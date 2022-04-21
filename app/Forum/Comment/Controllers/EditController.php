<?php

declare(strict_types=1);

namespace App\Forum\Comment\Controllers;

use App\Access\Models\AccessChecker\Forum\CommentAccessChecker;
use App\Access\Models\AccessChecker\Forum\TopicAccessChecker;
use App\Access\Models\Forbidden;
use App\Auth\Models\Auth;
use App\Forum\Category\Models\CategoryWriteRepository;
use App\Forum\Comment\Models\CommentWriteRepository;
use App\Forum\Topic\Models\TopicWriteRepository;
use App\SharedKernel\Controllers\ModuleViewRender;
use App\SharedKernel\File\Models\File;
use App\SharedKernel\File\Models\FileRepository;
use App\SharedKernel\Http\RequestFilesNormalizer;
use App\SharedKernel\Http\Validation;
use Ramsey\Uuid\Uuid;

final class EditController extends \Phalcon\Mvc\Controller
{
    use ModuleViewRender;

    public function mainAction(string $id): void
    {
        $comment = $this->getCommentRepository()->get($id);
        $topic = $this->getTopicRepository()->get($comment->topic_id);
        $category = $this->getCategoryRepository()->get($topic->category_id);

        if (!$this->getCommentAccessChecker()->canChange($topic->category_id, $comment->created_by)) {
            throw new Forbidden();
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

                $comment->edit($_POST['content'], $user->id);

                foreach ($images as $image) {
                    File::addForForumComment(
                        Uuid::uuid4(),
                        $comment->id,
                        $image['tmp_name'],
                        $image['name']
                    );
                }

                $this->response->redirect('/' . $category->slug . '/' . $topic->slug);

                return;
            } catch (\InvalidArgumentException $e) {
                $this->renderView([
                    'category' => $category,
                    'topic' => $topic,
                    'comment' => $comment,
                    'images' => $this->getFileRepository()->findByForumCommentId($comment->id),
                    'error' => $e->getMessage(),
                    'content' => $_POST['content']
                ]);
            }
        }

        $this->renderView([
            'category' => $category,
            'topic' => $topic,
            'comment' => $comment,
            'images' => $this->getFileRepository()->findByForumCommentId($comment->id),
        ]);
    }

    private function getFileRepository(): FileRepository
    {
        return new FileRepository();
    }

    private function getAuth(): Auth
    {
        return new Auth();
    }

    private function getCommentAccessChecker(): CommentAccessChecker
    {
        return new CommentAccessChecker();
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
}
