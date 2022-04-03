<?php

declare(strict_types=1);

namespace App\Access\Models\AccessChecker\Forum\ModerateCategory;

use Phalcon\Mvc\Model\Resultset;

interface CategoryStorage
{
    public function findAll(): Resultset;
}
