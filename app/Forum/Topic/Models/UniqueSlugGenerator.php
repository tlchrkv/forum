<?php

declare(strict_types=1);

namespace App\Forum\Topic\Models;

use App\SharedKernel\StringConverter;

final class UniqueSlugGenerator
{
    public static function generate(string $name): string
    {
        $config = include __DIR__ . '/../config.php';
        $categoryReadRepository = new TopicReadRepository();
        $number = 0;

        while (true) {
            $slug = StringConverter::readableToSlug($name) . ($number === 0 ? '' : '-' . $number);

            if (!in_array($slug, $config['excluding_slugs']) && !$categoryReadRepository->existBySlug($slug)) {
                return $slug;
            }

            $number++;
        }
    }
}
