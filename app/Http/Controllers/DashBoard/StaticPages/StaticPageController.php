<?php

namespace App\Http\Controllers\DashBoard\StaticPages;

use App\Http\Middleware\CheckPermission;
use App\Http\Requests\dashboard\StaticPages\StaticStoreRequest;
use Illuminate\Routing\Controller;
use App\Http\Requests\dashboard\StaticPages\StaticUpdateRequest;
use App\Services\Dashboard\StaticPages\StaticPageService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class StaticPageController extends Controller
{
    public function __construct(protected StaticPageService $service)
    {
        $this->middleware(CheckPermission::class .':create-users')->only(['store']);
        $this->middleware(CheckPermission::class .':update-users')->only(['update']);
        $this->middleware(CheckPermission::class .':delete-users')->only(['destroy']);
        $this->middleware(CheckPermission::class .':view-users')->only(['show' , 'index']);
    }

    public function index(Request $request): JsonResponse
    {
        return $this->service->index($request);
    }

    public function show($slug,Request $request): JsonResponse
    {
        return $this->service->showData($slug,$request);
    }

    public function store(StaticStoreRequest $request): JsonResponse
    {
        return $this->service->store($request->validated());
    }

    public function update($id , StaticUpdateRequest $request): JsonResponse
    {
        return $this->service->update($id,$request->validated());
    }

    public function destroy($id): JsonResponse
    {
        return $this->service->destroy($id);
    }
}
