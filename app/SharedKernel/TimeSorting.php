<?php

declare(strict_types=1);

namespace App\SharedKernel;

use App\SharedKernel\Structs\Enum;

final class TimeSorting extends Enum
{
    public static function newest(): self
    {
        return new self('newest');
    }

    public static function oldest(): self
    {
        return new self('oldest');
    }
}
