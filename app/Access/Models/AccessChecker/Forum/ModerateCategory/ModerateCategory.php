<?php

declare(strict_types=1);

namespace App\Access\Models\AccessChecker\Forum\ModerateCategory;

use App\Forum\Category\Models\Category;
use App\Forum\Category\Models\CategoryRepository;

final class ModerateCategory extends \Phalcon\Mvc\Model
{
    public function initialize(): void
    {
        $this->setSource('access_forum_moderate_categories');
    }

    public static function add($categoryId, $userId): void
    {
        $moderateCategory = new self([
            'user_id' => $userId,
            'category_id' => $categoryId,
        ]);

        $moderateCategory->save();
    }

    public function getCategory(): Category
    {
        return (new CategoryRepository())->get($this->category_id);
    }
}
