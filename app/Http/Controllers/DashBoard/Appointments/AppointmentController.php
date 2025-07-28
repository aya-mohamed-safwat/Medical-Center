<?php

namespace App\Http\Controllers\DashBoard\Appointments;

use App\Http\Middleware\CheckPermission;
use Illuminate\Routing\Controller;
use App\Http\Requests\dashboard\Sessions\SessionIndexRequest;
use App\Http\Requests\dashboard\Sessions\SessionUpdateRequest;
use App\Models\Appointment;
use App\Services\Dashboard\Appointments\AppointmentService;
use Illuminate\Http\JsonResponse;

class AppointmentController extends Controller
{
    public function __construct(protected AppointmentService $service)
    {
        $this->middleware(CheckPermission::class .':update-sessions')->only(['update']);
        $this->middleware(CheckPermission::class .':view-sessions')->only(['show' , 'index']);
    }

    public function index(SessionIndexRequest $request): JsonResponse
    {
        return $this->service->index($request);
    }

    public function show(Appointment $appointment): JsonResponse
    {
        return $this->service->show($appointment->id);
    }

    public function update(Appointment $appointment ,SessionUpdateRequest $request): JsonResponse
    {
        return $this->service->update($appointment->id , $request->validated());
    }
}
