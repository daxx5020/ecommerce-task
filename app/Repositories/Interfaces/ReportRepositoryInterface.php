<?php

namespace App\Repositories\Interfaces;

use Illuminate\Support\Collection;

interface ReportRepositoryInterface
{
    public function topUsers(array $filters): Collection;
}
