<?php

declare(strict_types=1);

namespace App\Auth\Controllers;

use App\Auth\Models\Auth;

final class LogoutController extends \Phalcon\Mvc\Controller
{
    public function execAction(): void
    {
        $this->getAuth()->logout();
    }

    private function getAuth(): Auth
    {
        return new Auth();
    }
}
