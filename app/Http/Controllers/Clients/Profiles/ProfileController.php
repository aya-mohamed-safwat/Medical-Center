<?php

namespace App\Http\Controllers\Clients\Profiles;

use App\Http\Requests\Clients\Auth\PhoneRequest;
use App\Http\Requests\Clients\Otp\OtpRequest;
use App\Http\Requests\Clients\Profiles\ProfileUpdateRequest;
use App\Http\Requests\dashboard\Admin\PasswordRequest\PasswordRequest;
use App\Services\Clients\Profiles\ProfileService;
use Illuminate\Http\JsonResponse;

class ProfileController
{
    public function __construct(protected ProfileService $profileService){}

    public function show($id): JsonResponse
    {
        return $this->profileService->show($id);
    }

    public function update(ProfileUpdateRequest $request, int $id): JsonResponse
    {
        return $this->profileService->update($id, $request->validated());
    }

    public function changePassword(PasswordRequest $request): JsonResponse
    {
        return $this->profileService->changePassword($request);
    }
    public function changePhone(PhoneRequest $request): JsonResponse
    {
        return $this->profileService->changePhone($request);
    }

    public function confirmPhoneOtp(OtpRequest $request): JsonResponse
    {
        return $this->profileService->confirmPhoneOtp($request);
    }

    public function destroy(int $id): JsonResponse
    {
        return $this->profileService->destroy($id);
    }
}
