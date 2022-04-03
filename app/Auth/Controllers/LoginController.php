<?php

declare(strict_types=1);

namespace App\Auth\Controllers;

use App\Auth\Models\Auth;
use App\SharedKernel\Http\Validation;

final class LoginController extends \Phalcon\Mvc\Controller
{
    public function execAction(): void
    {
        if ($this->request->isPost()) {
            $validation = new Validation([
                'name' => 'required',
                'password' => 'required'
            ]);

            $validation->validate($_POST);

            $this->getAuth()->login($_POST['name'], $_POST['password']);
        }

        echo $this->view->render(__DIR__ . '/../Views/login');
    }

    private function getAuth(): Auth
    {
        return new Auth();
    }
}
