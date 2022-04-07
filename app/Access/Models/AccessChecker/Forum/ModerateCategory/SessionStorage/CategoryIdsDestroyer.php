<?php

declare(strict_types=1);

namespace App\Access\Models\AccessChecker\Forum\ModerateCategory\SessionStorage;

final class CategoryIdsDestroyer
{
    public function exec(): void
    {
        $this->getSession()->destroy('moderate_categories');
    }

    private function getSession()
    {
        return \Phalcon\DI::getDefault()->getShared('session');
    }
}
