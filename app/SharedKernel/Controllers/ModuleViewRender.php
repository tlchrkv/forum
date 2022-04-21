<?php

declare(strict_types=1);

namespace App\SharedKernel\Controllers;

use App\SharedKernel\StringConverter;

trait ModuleViewRender
{
    public function renderView(array $vars = []): void
    {
        $appDir = str_replace(
            StringConverter::classNameToDir(ModuleViewRender::class),
            '',
            __DIR__
        );

        $classNameExploded = explode('\\', get_called_class());
        $viewName = strtolower(str_replace('Controller', '', end($classNameExploded)));

        echo $this->view->render(
            $appDir . StringConverter::classNameToDir(get_called_class()) . '/../Views/' . $viewName,
            $vars
        );
    }
}
