<?php

namespace App\Http\Controllers\DashBoard\Sliders;

use App\Http\Middleware\CheckPermission;
use App\Http\Requests\dashboard\Sliders\SliderStoreRequest;
use App\Http\Requests\dashboard\Sliders\SliderUpdateRequest;
use Illuminate\Routing\Controller;
use App\Services\Dashboard\Sliders\SliderService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class SliderController extends Controller
{
    public function __construct(protected SliderService $sliderService)
    {
        $this->middleware(CheckPermission::class .':create-sliders')->only(['store']);
        $this->middleware(CheckPermission::class .':update-sliders')->only(['update']);
        $this->middleware(CheckPermission::class .':delete-sliders')->only(['destroy']);
        $this->middleware(CheckPermission::class .':view-sliders')->only(['show' , 'index']);
    }

    public function index(Request $request): JsonResponse
    {
        return $this->sliderService->index($request);
    }

    public function show($id): JsonResponse
    {
        return $this->sliderService->show($id);
    }

    public function store(SliderStoreRequest $request): JsonResponse
    {
        return $this->sliderService->store($request->validated());
    }

    public function update($id, SliderUpdateRequest $request): JsonResponse
    {
        return $this->sliderService->update($id, $request->validated());
    }

    public function destroy($id): JsonResponse
    {
        return $this->sliderService->destroy($id);
    }
}
