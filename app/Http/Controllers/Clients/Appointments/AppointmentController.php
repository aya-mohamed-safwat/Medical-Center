<?php

namespace App\Http\Controllers\Clients\Appointments;

use App\Http\Requests\Clients\Appointments\SessionIndexRequest;
use App\Http\Requests\Clients\Appointments\SessionStoreRequest;
use App\Http\Requests\Clients\Appointments\SessionUpdateRequest;
use App\Models\Appointment;
use App\Services\Clients\Appointments\AppointmentService;
use Illuminate\Http\JsonResponse;

class AppointmentController
{
    public function __construct(protected AppointmentService $appointmentService){}

    public function index(SessionIndexRequest $request): JsonResponse
    {
        return $this->appointmentService->index($request);
    }

    public function show($id): JsonResponse
    {
        return $this->appointmentService->show($id);
    }

    public function store(SessionStoreRequest $request): JsonResponse
    {
        return $this->appointmentService->store($request->validated());
    }

    public function update(Appointment $appointment , SessionUpdateRequest $request): JsonResponse
    {
        return $this->appointmentService->update($appointment->id, $request->validated());
    }

    public function cancel($id): JsonResponse
    {
        return $this->appointmentService->canceled($id);
    }


}
