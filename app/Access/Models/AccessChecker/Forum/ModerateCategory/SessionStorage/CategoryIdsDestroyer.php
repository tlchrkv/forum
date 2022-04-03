<?php

declare(strict_types=1);

namespace App\Access\Models\AccessChecker\Forum\ModerateCategory\SessionStorage;

final class CategoryIdsDestroyer
{
    public function exec(): array
    {
        return $this->getSession()->destroy('moderate_categories');
    }

    private function getSession()
    {
        return diShared('session');
    }
}
