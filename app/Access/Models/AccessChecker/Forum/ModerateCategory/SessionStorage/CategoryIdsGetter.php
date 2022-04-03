<?php

declare(strict_types=1);

namespace App\Access\Models\AccessChecker\Forum\ModerateCategory\SessionStorage;

final class CategoryIdsGetter
{
    public function exec(): array
    {
        return $this->getSession()->get('moderate_categories', []);
    }

    private function getSession()
    {
        return diShared('session');
    }
}
