<?php

declare(strict_types=1);

namespace App\Forum\Category\Models;

final class Topic
{
    public $name;
    public $slug;

    public function __construct(string $name, string $slug)
    {
        $this->name = $name;
        $this->slug = $slug;
    }
}
