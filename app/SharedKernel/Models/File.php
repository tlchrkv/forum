<?php

declare(strict_types=1);

namespace App\SharedKernel\Models;

final class File extends \Phalcon\Mvc\Model
{
    public function initialize(): void
    {
        $this->setSource('files');
    }
}
