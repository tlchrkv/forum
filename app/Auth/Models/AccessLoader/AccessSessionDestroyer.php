<?php

declare(strict_types=1);

namespace App\Auth\Models\AccessLoader;

interface AccessSessionDestroyer
{
    public function exec(): void;
}
