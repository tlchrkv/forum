<?php

declare(strict_types=1);

namespace App\Access\Models\AccessChecker\Forum\ModerateCategory;

final class ModerateCategory extends \Phalcon\Mvc\Model
{
    public function initialize(): void
    {
        $this->setSource('access_forum_moderate_categories');
    }
}
