<?php

declare(strict_types=1);

namespace App\SharedKernel\Controllers;

trait Validation
{
    /**
     * @throws \InvalidArgumentException
     */
    public function validatePostRequest(array $rules): void
    {
        (new \App\SharedKernel\Http\Validation($rules))->validate($_POST);
    }
}
