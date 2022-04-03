<?php

declare(strict_types=1);

namespace App\Auth\Adapters;

use App\Access\Models\AccessChecker\Forum\ModerateCategory\SessionStorage\CategoryIdsSetter;
use App\Auth\Models\AccessLoader\AccessSessionSetter;
use Ramsey\Uuid\UuidInterface;

final class AccessSessionSetterAdapter implements AccessSessionSetter
{
    private $categoryIdsSetter;

    public function __construct(CategoryIdsSetter $categoryIdsSetter)
    {
        $this->categoryIdsSetter = $categoryIdsSetter;
    }

    public function exec(UuidInterface $userId): void
    {
        $this->categoryIdsSetter->exec($userId);
    }
}
