<?php

namespace App\Http\Controllers\DashBoard\Services;

use App\Http\Middleware\CheckPermission;
use Illuminate\Routing\Controller;
use App\Http\Requests\dashboard\Services\ServiceStoreRequest;
use App\Http\Requests\dashboard\Services\ServiceUpdateRequest;
use App\Services\Dashboard\Services\ServiceService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    public function __construct(protected ServiceService $service)
    {
        $this->middleware(CheckPermission::class .':create-services')->only(['store']);
        $this->middleware(CheckPermission::class .':update-services')->only(['update']);
        $this->middleware(CheckPermission::class .':delete-services')->only(['destroy']);
        $this->middleware(CheckPermission::class .':view-services')->only(['show' , 'index']);
    }

    public function index(Request $request): JsonResponse{
        return $this->service->index($request);
    }

    public function show($id): JsonResponse
    {
        return $this->service->show($id);
    }

    public function store(ServiceStoreRequest $request): JsonResponse
    {
        return $this->service->store($request->validated());
    }

    public function update(ServiceUpdateRequest $request, int $id): JsonResponse
    {
        return $this->service->update($id, $request->validated());
    }

    public function destroy(int $id): JsonResponse
    {
        return $this->service->destroy($id);
    }
}
