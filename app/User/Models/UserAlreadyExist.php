<?php

declare(strict_types=1);

namespace App\User\Models;

final class UserAlreadyExist extends \DomainException
{
    public function __construct()
    {
        parent::__construct('User with same name already exist');
    }
}
