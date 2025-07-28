<?php

namespace App\Http\Controllers\DashBoard\Active;

use App\Http\Middleware\CheckPermission;
use Illuminate\Routing\Controller;
use App\Http\Requests\dashboard\Active\ActiveRequest;
use App\Services\Dashboard\Active\ActiveService;
use Illuminate\Http\JsonResponse;

class ActiveController extends Controller
{
    public function __construct(protected ActiveService $activeService)
    {
        $this->middleware(CheckPermission::class .':active')->only(['toggle']);
    }

    public function toggle(ActiveRequest $request): JsonResponse
    {
        return $this->activeService->toggle($request);
    }
}
