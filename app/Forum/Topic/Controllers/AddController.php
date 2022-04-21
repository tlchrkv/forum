<?php

declare(strict_types=1);

namespace App\Forum\Topic\Controllers;

use App\Access\Models\AccessChecker\Forum\TopicAccessChecker;
use App\Access\Models\Forbidden;
use App\Auth\Models\Auth;
use App\Forum\Category\Models\CategoryWriteRepository;
use App\Forum\Topic\Models\Topic;
use App\SharedKernel\Controllers\ModuleViewRender;
use App\SharedKernel\File\Models\File;
use App\SharedKernel\Http\Validation;
use Ramsey\Uuid\Uuid;

final class AddController extends \Phalcon\Mvc\Controller
{
    use ModuleViewRender;

    public function mainAction(string $categorySlug): void
    {
        if (!$this->getTopicAccessChecker()->canAdd()) {
            throw new Forbidden();
        }

        $category = $this->getCategoryRepository()->getBySlug($categorySlug);

        if ($this->request->isPost()) {
            try {
                $validation = new Validation([
                    'name' => 'required|length_between:1,64',
                    'content' => 'required|length_between:1,20000',
                ]);

                $validation->validate($_POST);

                $images = [];
                if ($_FILES['images']['error'][0] !== 4) {
                    $images = $this->normalizeRequestFiles($_FILES['images']);

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

                $topic = Topic::add(
                    Uuid::uuid4(),
                    Uuid::fromString($category->id),
                    $_POST['name'],
                    $_POST['content'],
                    Uuid::fromString($user->id)
                );

                foreach ($images as $image) {
                    File::addForForumTopic(
                        Uuid::uuid4(),
                        $topic->id,
                        $image['tmp_name'],
                        $image['name']
                    );
                }

                $this->response->redirect('/' . $categorySlug . '/' . $topic->slug);

                return;
            } catch (\InvalidArgumentException $e) {
                $this->renderView([
                    'category' => $category,
                    'error' => $e->getMessage(),
                    'name' => $_POST['name'],
                    'content' => $_POST['content'],
                ]);

                return;
            }
        }

        $this->renderView(['category' => $category]);
    }

    private function getTopicAccessChecker(): TopicAccessChecker
    {
        return new TopicAccessChecker();
    }

    private function getAuth(): Auth
    {
        return new Auth();
    }

    private function getCategoryRepository(): CategoryWriteRepository
    {
        return new CategoryWriteRepository();
    }

    private function normalizeRequestFiles(array $requestFiles): array
    {
        $normalizedFiles = [];
        $count = count($requestFiles['name']);
        $keys = array_keys($requestFiles);

        for ($i = 0; $i < $count; $i++) {
            foreach ($keys as $key) {
                $normalizedFiles[$i][$key] = $requestFiles[$key][$i];
            }
        }

        return $normalizedFiles;
    }
}
