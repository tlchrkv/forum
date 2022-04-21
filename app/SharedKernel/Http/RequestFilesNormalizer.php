<?php

declare(strict_types=1);

namespace App\SharedKernel\Http;

final class RequestFilesNormalizer
{
    public static function normalize(array $requestFiles): array
    {
        $normalizedFiles = [];
        $count = count($requestFiles['name']);
        $keys = array_keys($requestFiles);

        for ($i = 0; $i < $count; $i++) {
            foreach ($keys as $key) {
                $normalizedFiles[$i][$key] = $requestFiles[$key][$i];
            }
        }

        return $normalizedFiles;
    }
}
