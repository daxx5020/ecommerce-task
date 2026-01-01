<?php

namespace App\Http\Controllers\Api\Admin;

use Illuminate\Http\Request;
use App\Services\Admin\ReportService;
use App\Http\Controllers\Api\BaseApiController;

class ReportController extends BaseApiController
{
    public function __construct(
        protected ReportService $reportService
    ) {}

    /**
     * @OA\Get(
     *     path="/api/admin/reports/top-users",
     *     tags={"Admin - Reports"},
     *     summary="Top users by order metrics",
     *     security={{"sanctum":{}}},
     *     @OA\Parameter(name="from", in="query", example="2026-01-01"),
     *     @OA\Parameter(name="to", in="query", example="2026-01-31"),
     *     @OA\Response(response=200, description="Success")
     * )
     */
    public function topUsers(Request $request)
    {
        $data = $this->reportService->topUsers($request->all());

        return $this->ok([
            'users' => $data,
        ]);
    }
}
