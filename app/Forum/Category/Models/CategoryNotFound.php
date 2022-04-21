<?php

declare(strict_types=1);

namespace App\Forum\Category\Models;

use App\SharedKernel\Exceptions\NotFoundException;

final class CategoryNotFound extends NotFoundException
{
    public function __construct()
    {
        parent::__construct('Category not found');
    }
}
