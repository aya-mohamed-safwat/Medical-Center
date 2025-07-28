<?php

namespace App\Services\Dashboard\Admin\Profiles;

use App\Http\Requests\dashboard\Admin\PasswordRequest\PasswordRequest;
use App\Http\Resources\Dashboard\Admins\AdminResource;
use App\Models\User;
use App\Services\BaseServices\BaseService;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use function App\Helpers\json;

class ProfileService extends BaseService
{
    protected $model=User::class;
    protected $resource=AdminResource::class;

    public function changePassword(PasswordRequest $request): JsonResponse
    {
        $currentUser = Auth::user();
        if(Hash::check( $request->old_password , $currentUser->password ))
        {
            DB::beginTransaction();
            try {
                $currentUser->update(['password'=>$request->new_password]);
            DB::commit();
            return json(__('response.success'),__('response.auth.change_pass'),new AdminResource($currentUser),200);
            }catch(\Exception $e)
            {
            DB::rollBack();
            Log::info(json_encode($e->getMessage()));
            return json(__('response.failed'),__('response.error.update'),'',500);
            }
        }
        return json(__('response.failed'),__('response.auth.wrong_pass'),'',500);
    }


}
