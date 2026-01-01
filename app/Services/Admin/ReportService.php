<?php

namespace App\Services\Admin;

use App\Repositories\Interfaces\ReportRepositoryInterface;

class ReportService
{
    public function __construct(
        protected ReportRepositoryInterface $reportRepository
    ) {}

    public function topUsers(array $filters)
    {
        return $this->reportRepository->topUsers($filters);
    }
}
