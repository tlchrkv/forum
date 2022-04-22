<?php

declare(strict_types=1);

namespace App\SharedKernel\File\Controllers;

use App\SharedKernel\File\Models\FileRepository;

final class DeleteController extends \Phalcon\Mvc\Controller
{
    public function mainAction($id): void
    {
        (new FileRepository())->get($id)->delete();

        $this->response->redirect($_GET['redirect_to']);
    }
}
