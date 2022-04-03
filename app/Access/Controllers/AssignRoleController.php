<?php

declare(strict_types=1);

namespace App\Access\Controllers;

final class AssignRoleController extends \Phalcon\Mvc\Controller
{
    public function execAction(): void
    {
        if ($this->request->isPost()) {

        }

        echo $this->view->render(__DIR__ . '/../Views/assign-role');
    }
}
