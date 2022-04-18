<?php

declare(strict_types=1);

namespace App\Auth\Models;

final class LoginFailed extends \Exception
{
    public function __construct()
    {
        parent::__construct('Username or password isn\'t correct');
    }
}
