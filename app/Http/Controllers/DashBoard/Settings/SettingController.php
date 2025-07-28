<?php

namespace App\Http\Controllers\DashBoard\Settings;

use App\Http\Middleware\CheckPermission;
use Illuminate\Routing\Controller;
use App\Http\Requests\dashboard\Settings\SettingUpdateRequest;
use App\Services\Dashboard\Settings\SettingService;
use Illuminate\Http\JsonResponse;

class SettingController extends Controller
{
    public function __construct(protected SettingService $settingService)
    {
        $this->middleware(CheckPermission::class .':update-settings')->only(['update']);
    }

    public function update(SettingUpdateRequest $request): JsonResponse
    {
       return $this->settingService->update($request);
    }
}
