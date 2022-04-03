<?php

declare(strict_types=1);

namespace App\Access\Models\AccessChecker\Forum\ModerateCategory\SessionStorage;

use App\Access\Models\AccessChecker\Forum\ModerateCategory\ModerateCategoryRepository;
use Ramsey\Uuid\UuidInterface;

final class CategoryIdsSetter
{
    private $moderateCategoryRepository;

    public function __construct()
    {
        $this->moderateCategoryRepository = new ModerateCategoryRepository();
    }

    public function exec(UuidInterface $userId): void
    {
        $session = $this->getSession();
        $session->set('moderate_categories', []);

        $moderateCategories = $this->moderateCategoryRepository->findByUserId($userId);

        foreach ($moderateCategories as $moderateCategory) {
            $session->set(
                'moderate_categories',
                array_merge(
                    $session->get('moderate_categories'),
                    [$moderateCategory->category_id]
                )
            );
        }
    }

    private function getSession()
    {
        return diShared('session');
    }
}
