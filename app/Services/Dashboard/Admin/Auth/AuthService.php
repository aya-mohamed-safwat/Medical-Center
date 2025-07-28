<?php

namespace App\Services\Dashboard\Admin\Auth;

use App\Http\Requests\dashboard\Admin\Auth\LoginRequest;
use App\Http\Resources\Dashboard\Admins\AdminResource;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use function App\Helpers\json;

class AuthService
{
    public function login(LoginRequest $request):JsonResponse
    {
        if(!$token = Auth::attempt($request->only('email', 'password')))
        {
            return json(__('response.failed'), __('response.auth.invalid_login'),'', 401);
        }
        $user = auth()->user();
        $profileData = new AdminResource($user);
        return json(__('response.success'),'' , ['access_token' => $token , 'profile' =>  $profileData],200);
    }

    public function logout():JsonResponse{
        auth()->logout();
        return json(__('response.success'),__('response.auth.logout') , '',200);
    }

}
