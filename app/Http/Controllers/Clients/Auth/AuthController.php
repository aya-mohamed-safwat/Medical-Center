<?php

namespace App\Http\Controllers\Clients\Auth;

use App\Http\Requests\Clients\Auth\LoginRequest;
use App\Http\Requests\Clients\Auth\NumberRequest;
use App\Http\Requests\Clients\Auth\RegisterRequest;
use App\Http\Requests\Clients\Auth\ResetPasswordRequest;
use App\Http\Requests\Clients\Otp\OtpRequest;
use App\Services\Clients\Auth\AuthService;
use Illuminate\Http\JsonResponse;

class AuthController
{
    public function __construct(protected AuthService $authService){}

    public function register(RegisterRequest $request): JsonResponse
    {
        return $this->authService->register($request->number , $request->validated());
    }

    public function confirmOtp(OtpRequest $request): JsonResponse
    {
        return $this->authService->confirmOtp($request);
    }

    public function resendOtp(NumberRequest $request): JsonResponse
    {
        return $this->authService->resendOtp($request);
    }

    public function forgetPassword(NumberRequest $request): JsonResponse
    {
        return $this->authService->forgetPassword($request);
    }

    public function resetPassword(ResetPasswordRequest $request): JsonResponse
    {
        return $this->authService->resetPassword($request);
    }

    public function login(LoginRequest $request): JsonResponse
    {
        return $this->authService->login($request);
    }

    public function logout(): JsonResponse
    {
        return $this->authService->logout();
    }

}
