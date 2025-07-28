<?php

namespace App\Services\Dashboard\Notifications;

use App\Http\Requests\dashboard\Notifications\NotifyUserRequest;
use App\Models\User;
use App\Notifications\ClientNotification;
use Illuminate\Http\JsonResponse;
use function App\Helpers\json;

class NotifyUserService
{
    public function notifyUser(NotifyUserRequest $request ):JsonResponse{
        $user = User::where('role_id' , 3)->findOrFail($request->user_id);

        $user->Notify(new ClientNotification($request->title , $request->body));
        return json('success','notification is sent','',200);
    }
}
