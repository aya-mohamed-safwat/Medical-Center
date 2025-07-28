<?php

namespace App\Http\Controllers\DashBoard\Reports;

use App\Http\Requests\dashboard\Reports\ReportIndexRequest;
use App\Http\Requests\dashboard\Reports\ReportStoreRequest;
use App\Services\Dashboard\Reports\ReportService;
use Illuminate\Http\JsonResponse;

class ReportController
{
    public function __construct(protected ReportService $reportService){}

    public function store(ReportStoreRequest $request): JsonResponse
    {
        return $this->reportService->store($request->validated());
    }

    public function index(ReportIndexRequest $request): JsonResponse
    {
        return $this->reportService->index($request);
    }

    public function destroy($id): JsonResponse
    {
        return $this->reportService->destroy($id);
    }
}
