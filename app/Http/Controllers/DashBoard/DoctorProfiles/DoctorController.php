<?php

namespace App\Http\Controllers\DashBoard\DoctorProfiles;

use App\Http\Middleware\CheckPermission;
use Illuminate\Routing\Controller;
use App\Http\Requests\dashboard\Doctors\DoctorStoreRequest;
use App\Http\Requests\dashboard\Doctors\DoctorUpdateRequest;
use App\Services\Dashboard\DoctorProfiles\DoctorService;
use App\Services\Clients\Doctors\DoctorService as ClientDoctorService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class DoctorController extends Controller
{
    public function __construct(protected DoctorService $doctorService , protected ClientDoctorService $service)
    {
        $this->middleware(CheckPermission::class .':create-doctors')->only(['store']);
        $this->middleware(CheckPermission::class .':update-doctors')->only(['update']);
        $this->middleware(CheckPermission::class .':delete-doctors')->only(['destroy']);
        $this->middleware(CheckPermission::class .':view-doctors')->only(['show' , 'index']);
    }

    public function index(Request $request): JsonResponse
    {
        return $this->service->index($request);
    }

    public function show($id): JsonResponse
    {
        return $this->service->show($id);
    }

    public function store(DoctorStoreRequest $request): JsonResponse
    {
        return $this->doctorService->store($request->validated());
    }

    public function update(DoctorUpdateRequest $request, $id): JsonResponse
    {
        return $this->doctorService->update($id, $request->validated());
    }

    public function destroy($id): JsonResponse
    {
        return $this->doctorService->destroy($id);
    }
}
