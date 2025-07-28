<?php

namespace App\Http\Controllers\DashBoard\Admin\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\dashboard\Admin\Auth\LoginRequest;
use App\Services\Dashboard\Admin\Auth\AuthService;
use Illuminate\Http\JsonResponse;

class AuthController extends Controller
{
    public function __construct(protected AuthService $authService){}

    public function login(LoginRequest $request): JsonResponse
    {
        return $this->authService->login($request);
    }

    public function logout(): JsonResponse
    {
        return $this->authService->logout();
    }
}
