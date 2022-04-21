<?php

declare(strict_types=1);

namespace App\Forum\Category\Models;

final class CategoryAlreadyExist extends \DomainException
{
    public function __construct()
    {
        parent::__construct('Category with same name already exist');
    }
}
