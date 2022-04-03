<?php

declare(strict_types=1);

namespace App\Auth\Models;

final class IsNotAuthenticated extends \Exception
{
    public function __construct()
    {
        parent::__construct('Authentication required');
    }
}
