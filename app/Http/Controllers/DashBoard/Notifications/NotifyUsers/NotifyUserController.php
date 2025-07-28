<?php

namespace App\Http\Controllers\DashBoard\Notifications\NotifyUsers;

use App\Http\Middleware\CheckPermission;
use Illuminate\Routing\Controller;
use App\Http\Requests\dashboard\Notifications\NotifyUserRequest;
use App\Services\Dashboard\Notifications\NotifyUserService;
use Illuminate\Http\JsonResponse;

class NotifyUserController extends Controller
{
    public function __construct(protected NotifyUserService $notifyUserService)
    {
        $this->middleware(CheckPermission::class .':create-notifications')->only(['notifyUser']);
    }

    public function notifyUser(NotifyUserRequest $request):JsonResponse
    {
        return $this->notifyUserService->notifyUser($request);
    }
}
