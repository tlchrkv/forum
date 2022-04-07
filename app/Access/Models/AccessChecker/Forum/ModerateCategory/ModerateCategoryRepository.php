<?php

declare(strict_types=1);

namespace App\Access\Models\AccessChecker\Forum\ModerateCategory;

use Phalcon\Mvc\Model\Resultset;

final class ModerateCategoryRepository
{
    public function findByUserId($userId): Resultset
    {
        return ModerateCategory::find("user_id = '$userId'");
    }

    public function getByUserIdAndCategoryId($userId, $categoryId): ModerateCategory
    {
        return ModerateCategory::findFirst("user_id = '$userId' and category_id = '$categoryId'");
    }
}
