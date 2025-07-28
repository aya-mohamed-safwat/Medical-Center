<?php

namespace App\Services\Clients\Reports;

use App\Http\Requests\Clients\Reports\ReportRequest;
use App\Http\Resources\Dashboard\Reports\ReportResource;
use App\Models\Report;
use Illuminate\Http\JsonResponse;
use function App\Helpers\json;

class ReportService
{
    public function index(ReportRequest $request): JsonResponse
    {
        $reportQuery = Report::query();
        $reportData  = $reportQuery
            ->with('attachment')
            ->where('user_id', auth()->id())
            ->when($request->filled('type'), function ($query) use ($request) {
                $query->whereHas('attachment' , function ($query) use ($request) {
                    $query->where('file_type', $request->type);
                });
            })->latest()
             ->paginate();
        ReportResource::wrap('reportData');
        return json( __('response.success'), __('response.index'),ReportResource::collection($reportData)->response()->getData(),200);
    }
}
