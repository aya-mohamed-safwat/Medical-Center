<?php

namespace App\Services\Clients\Profiles;

use App\Http\Requests\Clients\Auth\PhoneRequest;
use App\Http\Requests\Clients\Otp\OtpRequest;
use App\Http\Requests\dashboard\Admin\PasswordRequest\PasswordRequest;
use App\Http\Resources\Clients\ClientProfiles\ClientAuthResource;
use App\Models\User;
use App\Services\BaseServices\BaseService;
use App\Services\Clients\Auth\OtpService;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use function App\Helpers\json;

class ProfileService extends BaseService
{
    protected $model = User::class;
    protected $resource = ClientAuthResource::class;

    public function __construct(protected OtpService $otpService){}

    public function show($id): JsonResponse
    {
        $user = User::where('role_id' , 3)->findOrFail($id);
        return json(__('response.success'),__('response.show'), new ClientAuthResource($user),200);
    }

    public function handleUpdate($id, array $data)
    {
        $user = User::where('role_id' , 3)->findOrFail($id);
        $user->update($data);
        return $user;
    }

    public function changePassword(PasswordRequest $request): JsonResponse
    {
        $currentUser = Auth::user();
        if(Hash::check( $request->old_password , $currentUser->password ))
        {
            DB::beginTransaction();
            try {
                $currentUser->update(['password' => $request->new_password]);
                DB::commit();
                return json(__('response.success'),__('response.done.update'),new ClientAuthResource($currentUser),200);
            }catch(\Exception $e)
            {
                DB::rollBack();
                Log::info(json_encode($e->getMessage()));
                return json(__('response.failed'),__('response.error.update'),'',422);
            }
        }
        return json(__('response.failed'),__('response.auth.wrong_pass'),'',401);
    }

    public function changePhone(phoneRequest $request):JsonResponse
    {
        $this->otpService->create($request->number);
        return json(__('response.success'), __('response.auth.check_your_sms'), '', 200);
    }

    public function confirmPhoneOtp(OtpRequest $request):JsonResponse
    {
        $otp = $this->otpService->validate($request->number, $request->code);
        if (!$otp) {
            return json(__('response.failed'), __('response.auth.expired_otp'), '', 400);
        }
        $profile = auth::user();
        $profile->update([
            'number' => $request->number,
        ]);
        $otp->delete();
        return json(__('response.success'),  __('response.auth.change_number'), '', 200);
    }

    public function handleDelete($id): void
    {
        $user = User::where('role_id' , 3)->findOrFail($id);
        $user->delete();
    }

}
