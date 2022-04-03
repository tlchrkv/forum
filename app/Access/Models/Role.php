<?php

declare(strict_types=1);

namespace App\Access\Models;

use App\SharedKernel\Structs\Enum;

final class Role extends Enum
{
    public static function user(): self
    {
        return new self('user');
    }

    public static function moderator(): self
    {
        return new self('moderator');
    }

    public static function admin(): self
    {
        return new self('admin');
    }
}
