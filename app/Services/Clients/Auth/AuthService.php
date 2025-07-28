<?php

namespace App\Services\Clients\Auth;

use App\Http\Requests\Clients\Auth\LoginRequest;
use App\Http\Requests\Clients\Auth\NumberRequest;
use App\Http\Requests\Clients\Auth\ResetPasswordRequest;
use App\Http\Requests\Clients\Otp\OtpRequest;
use App\Http\Resources\Clients\ClientProfiles\ClientAuthResource;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Hash;
use function App\Helpers\json;

class AuthService
{
    public function __construct(protected OtpService $otpService){}

    public function register($number,array $data):JsonResponse
    {
            Cache::put('pendingUser'. $number, $data, now()->addHours(24));
            $this->otpService->create($number);
            return json(__('response.success'), __('response.auth.check_your_sms'), '', 200);
    }

    public function confirmOtp(OtpRequest $request):JsonResponse
    {
        $pendingUser=Cache::get('pendingUser'.$request->number);
        if(!$pendingUser || $pendingUser['number'] !== $request->number)
        {
            return Json(__('response.success'),__('response.auth.invalid_email_or_otp'),'',400);
        }
        $otp = $this->otpService->validate($request->number, $request->code);
        if (!$otp)
        {
            return Json(__('response.failed'),__('response.auth.expired_otp'),'',400);
        }
        $this->createUser($pendingUser);
        Cache::forget('PendingUser'. $request->number);
        $otp->delete();

        return Json(__('response.success'),__('response.auth.verified_and_create'),'',200);
    }

    public function resendOtp(NumberRequest $request):JsonResponse
    {
        $cachedData = Cache::get('pendingUser'.$request->number,);
        if (!$cachedData || $cachedData['number'] !== $request->number)
        {
            return json(__('response.failed') ,__('response.auth.expired_otp') ,'',400);
        }
        $this->otpService->create($request->number);
        return json(__('response.success'),__('response.auth.check_your_sms'),'',200);
    }

    public function forgetPassword(NumberRequest $request):JsonResponse
    {
        if(!User::where('number',$request->number)->exists())
        {
            return json(__('response.failed') ,__('response.auth.wrong_number'),'',400);
        }
        $this->otpService->create($request->number);
        return json(__('response.success'),__('response.auth.check_your_sms'),'',200);

    }

    public function resetPassword(ResetPasswordRequest $request):JsonResponse
    {
            $otp = $this->otpService->validate($request->number, $request->code);
            if (!$otp) {
                return json(__('response.failed'), __('response.auth.expired_otp'), '', 400);
            }
            $profile = User::where('number', $request->number)->first();
            if (!$profile) {
                return json(__('response.failed'), __('response.auth.no_user'), '', 404);
            }
            $profile->update([
                'password' => Hash::make($request->password),
                'email_verified_at' => now(),
            ]);
            $otp->delete();
            return json(__('response.success'), __('response.auth.change_pass'), '', 200);
    }

    public function login(LoginRequest $request):JsonResponse
    {
        if(!$token = Auth::attempt($request->only('number', 'password'))){
            return json(__('response.failed'), __('response.auth.invalid_login'),'', 401);
        }
        $profileData = new ClientAuthResource(Auth::user());

        return json(__('response.success'),'' , ['access_token' => $token , 'profile' => $profileData],200);
    }

    public function logout():JsonResponse
    {
        auth()->logout();
        return json(__('response.success'),__('response.auth.logout') , '',200);
    }

    private function createUser(array $data):void{
        $userData = Arr::only($data, ['name', 'email', 'password' ,'role_id' , 'number' , 'fcm_token']);
        $userData['role_id'] = 3;
        $user = User::create($userData);
        $user->clientProfile()->create();
    }

}
