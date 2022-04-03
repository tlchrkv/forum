<?php

declare(strict_types=1);

namespace App\Access\Models\AccessChecker\Forum\ModerateCategory;

use Ramsey\Uuid\UuidInterface;
use Phalcon\Mvc\Model\Resultset;

final class ModerateCategoryRepository
{
    public function findByUserId(UuidInterface $userId): Resultset
    {
        return ModerateCategory::find("user_id = '$userId'");
    }
}
