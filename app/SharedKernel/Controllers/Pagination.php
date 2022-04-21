<?php

declare(strict_types=1);

namespace App\SharedKernel\Controllers;

trait Pagination
{
    public function getCurrentPage(): int
    {
        return (int) $this->request->getQuery('page', 'int', 1);
    }

    public function getSkipRowsNumber(int $rowsPerPage): int
    {
        return ($this->getCurrentPage() - 1) * $rowsPerPage;
    }

    public function getTotalPages(int $rowsTotal, int $rowsPerPage): int
    {
        return (int) ceil($rowsTotal / $rowsPerPage);
    }
}
