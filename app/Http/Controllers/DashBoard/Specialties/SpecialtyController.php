<?php

namespace App\Http\Controllers\DashBoard\Specialties;

use App\Http\Middleware\CheckPermission;
use Illuminate\Routing\Controller;
use App\Http\Requests\dashboard\Specialties\SpecialityStoreRequest;
use App\Http\Requests\dashboard\Specialties\SpecialityUpdateRequest;
use App\Services\Dashboard\Specialties\SpecialtyService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class SpecialtyController extends Controller
{
    public function __construct(protected SpecialtyService $specialtyService)
    {
        $this->middleware(CheckPermission::class .':create-specialities')->only(['store']);
        $this->middleware(CheckPermission::class .':update-specialities')->only(['update']);
        $this->middleware(CheckPermission::class .':delete-specialities')->only(['destroy']);
        $this->middleware(CheckPermission::class .':view-specialities')->only(['show' , 'index']);
    }

    public function index(Request $request): JsonResponse
    {
        return $this->specialtyService->index($request);
    }

    public function show(int $id): JsonResponse
    {
        return $this->specialtyService->show($id);
    }

    public function store(SpecialityStoreRequest $request): JsonResponse
    {
        return $this->specialtyService->store($request->validated());
    }

    public function update(SpecialityUpdateRequest $request, int $id): JsonResponse
    {
        return $this->specialtyService->update($id, $request->validated());
    }

    public function destroy(int $id): JsonResponse
    {
        return $this->specialtyService->destroy($id);
    }

}
