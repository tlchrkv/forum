<?php

declare(strict_types=1);

namespace App\SharedKernel\Controllers;

final class Controller extends \Phalcon\Mvc\Controller
{
    public function render(): void
    {
        echo $this->view->render(__DIR__ . '/../Views/add');
    }
}
