<?php

declare(strict_types=1);

namespace App\Auth\Adapters;

use App\Access\Models\AccessChecker\Forum\ModerateCategory\SessionStorage\CategoryIdsDestroyer;
use App\Auth\Models\AccessLoader\AccessSessionDestroyer;

final class AccessSessionDestroyerAdapter implements AccessSessionDestroyer
{
    private $categoryIdsDestroyer;

    public function __construct(CategoryIdsDestroyer $categoryIdsDestroyer)
    {
        $this->categoryIdsDestroyer = $categoryIdsDestroyer;
    }

    public function exec(): void
    {
        $this->categoryIdsDestroyer->exec();
    }
}
