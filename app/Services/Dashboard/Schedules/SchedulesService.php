<?php

namespace App\Services\Dashboard\Schedules;

use App\Http\Resources\Dashboard\Schedule\ScheduleResource;
use App\Models\Schedule;
use App\Services\BaseServices\BaseService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use function App\Helpers\availableTimes;
use function App\Helpers\json;

class SchedulesService extends BaseService
{
    protected $model    = Schedule::class;
    protected $resource = ScheduleResource::class;

    public function index($request): JsonResponse
    {
        $scheduleQuery = Schedule::query();
        $scheduleData = $scheduleQuery
            ->when($request->filled('doctor'), function ($query) use ($request) {
                return $query->where('doctor_profile_id', $request->doctor);
            })
            ->when($request->filled('date'), function ($query) use ($request) {
                return $query->where('date', $request->date);
            })
            ->when($request->filled('active'), function ($query) use ($request) {
                $query->active($request->active);
            })
            ->latest()
            ->paginate();
        $this->resource::wrap('scheduleData');
        return json(__('response.success'),__('response.index'),ScheduleResource::collection($scheduleData)->response()->getData(),200);
    }

    public function availableTimes($request): array|Collection
    {
        return availableTimes($request->input('doctor_id'), $request->input('date'));
    }

}
