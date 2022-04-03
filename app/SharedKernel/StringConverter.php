<?php

declare(strict_types=1);

namespace App\SharedKernel;

final class StringConverter
{
    public static function snakeCaseToCamelCase(string $value): string
    {
        $result = str_replace(' ', '', ucwords(str_replace('_', ' ', $value)));
        $result[0] = strtolower($result[0]);

        return $result;
    }

    public static function snakeCaseToReadable(string $value, bool $upFirst = false): string
    {
        $result = str_replace('_', ' ', $value);

        return $upFirst ? ucfirst($result) : $result;
    }

    public static function readableToSlug(string $value): string
    {
        $divider = '-';

        $value = preg_replace('~[^\pL\d]+~u', $divider, $value);
        $value = iconv('utf-8', 'us-ascii//TRANSLIT', $value);
        $value = preg_replace('~[^-\w]+~', '', $value);
        $value = trim($value, $divider);
        $value = preg_replace('~-+~', $divider, $value);

        return strtolower($value);
    }
}
