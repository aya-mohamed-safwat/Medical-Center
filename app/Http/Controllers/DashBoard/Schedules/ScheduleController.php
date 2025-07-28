<?php

namespace App\Http\Controllers\DashBoard\Schedules;

use App\Http\Middleware\CheckPermission;
use Illuminate\Routing\Controller;
use App\Http\Requests\dashboard\Schedules\AvailableTimesRequest;
use App\Http\Requests\dashboard\Schedules\ScheduleIndexRequest;
use App\Http\Requests\dashboard\Schedules\ScheduleStoreRequest;
use App\Http\Requests\dashboard\Schedules\ScheduleUpdateRequest;
use App\Services\Dashboard\Schedules\SchedulesService;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Collection;

class ScheduleController extends Controller
{
    public function __construct(protected SchedulesService $schedulesService)
    {
        $this->middleware(CheckPermission::class .':create-schedules')->only(['store']);
        $this->middleware(CheckPermission::class .':update-schedules')->only(['update']);
        $this->middleware(CheckPermission::class .':delete-schedules')->only(['destroy']);
        $this->middleware(CheckPermission::class .':view-schedules')->only(['show' , 'index']);
    }

    public function index(ScheduleIndexRequest $request): JsonResponse
    {
        return $this->schedulesService->index($request);
    }

    public function show($id): JsonResponse
    {
        return $this->schedulesService->show($id);
    }

    public function store(ScheduleStoreRequest $request): JsonResponse
    {
        return $this->schedulesService->store($request->validated());
    }

    public function update(ScheduleUpdateRequest $request , $id): JsonResponse
    {
        return $this->schedulesService->update($id , $request->validated());
    }

    public function destroy($id): JsonResponse
    {
        return $this->schedulesService->destroy($id);
    }

    public function availableTimes(AvailableTimesRequest $request): array|Collection
    {
        return $this->schedulesService->availableTimes($request);
    }
}
