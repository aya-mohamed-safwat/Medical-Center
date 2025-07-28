<?php

namespace App\Http\Controllers\DashBoard\Admin\Profiles;

use App\Http\Middleware\CheckPermission;
use Illuminate\Routing\Controller;
use App\Http\Requests\dashboard\Admin\PasswordRequest\PasswordRequest;
use App\Http\Requests\dashboard\Admin\updateRequest\AdminUpdateRequest;
use App\Services\Dashboard\Admin\Profiles\ProfileService;
use Illuminate\Http\JsonResponse;

class ProfileController extends Controller
{
    public function __construct(protected ProfileService $profileService)
    {
        $this->middleware(CheckPermission::class .':changePass-admin')->only(['changePassword']);
        $this->middleware(CheckPermission::class .':update-admin')->only(['update']);
        $this->middleware(CheckPermission::class .':view-admin')->only(['show']);
    }

    public function show($id): JsonResponse
    {
        return $this->profileService->show($id);
    }

    public function update($id, AdminUpdateRequest $request): JsonResponse
    {
        return $this->profileService->update($id, $request->validated());
    }

    public function changePassword(PasswordRequest $request): JsonResponse
    {
        return $this->profileService->changePassword($request);
    }


}
