<?php

declare(strict_types=1);

namespace App\Auth\Controllers;

use App\Auth\Models\Auth;
use App\Auth\Models\LoginFailed;
use App\SharedKernel\Controllers\ModuleViewRender;
use App\SharedKernel\Controllers\Validation;

final class LoginController extends \Phalcon\Mvc\Controller
{
    use ModuleViewRender;
    use Validation;

    public function execAction(): void
    {
        if ($this->request->isPost()) {
            try {
                $this->validatePostRequest([
                    'name' => 'required',
                    'password' => 'required'
                ]);

                $this->getAuth()->login($_POST['name'], $_POST['password']);
                $this->response->redirect('/');

                return;
            } catch (\InvalidArgumentException|LoginFailed $exception) {
                $this->renderView(['error' => $exception->getMessage()]);

                return;
            }
        }

        $this->renderView();
    }

    private function getAuth(): Auth
    {
        return new Auth();
    }
}
