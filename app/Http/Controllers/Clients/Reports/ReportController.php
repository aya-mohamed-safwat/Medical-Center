<?php

namespace App\Http\Controllers\Clients\Reports;

use App\Http\Requests\Clients\Reports\ReportRequest;
use App\Services\Clients\Reports\ReportService;
use Illuminate\Http\JsonResponse;

class ReportController
{
    public function __construct(protected ReportService $reportService){}

    public function index(ReportRequest $request): JsonResponse
    {
        return $this->reportService->index($request);
    }
}
