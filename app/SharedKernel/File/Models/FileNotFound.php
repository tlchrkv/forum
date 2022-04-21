<?php

declare(strict_types=1);

namespace App\SharedKernel\File\Models;

use App\SharedKernel\Exceptions\NotFoundException;

final class FileNotFound extends NotFoundException
{
    public function __construct()
    {
        parent::__construct('File not found');
    }
}
