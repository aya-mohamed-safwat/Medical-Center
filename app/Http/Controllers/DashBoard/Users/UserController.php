<?php

namespace App\Http\Controllers\DashBoard\Users;

use App\Http\Middleware\CheckPermission;
use App\Http\Requests\dashboard\Active\IndexRequest;
use App\Http\Requests\Users\UserStoreRequest;
use App\Http\Requests\Users\UserUpdateRequest;
use App\Models\User;
use App\Services\Dashboard\Users\UserService;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;

class UserController extends Controller
{
    public function __construct(protected UserService $userService)
    {
        $this->middleware(CheckPermission::class .':create-users')->only(['store']);
        $this->middleware(CheckPermission::class .':update-users')->only(['update']);
        $this->middleware(CheckPermission::class .':delete-users')->only(['destroy']);
        $this->middleware(CheckPermission::class .':view-users')->only(['show' , 'index']);
    }

    public function index(IndexRequest $request): JsonResponse
    {
        return $this->userService->index($request);
    }

    public function show(User $user): JsonResponse
    {
        return $this->userService->show($user->id);
    }

    public function store(UserStoreRequest $request): JsonResponse
    {
        return $this->userService->store($request->validated());
    }

    public function update(User $user, UserUpdateRequest $request): JsonResponse
    {
        return $this->userService->update($user->id , $request->validated());
    }

    public function destroy(User $user): JsonResponse
    {
        return $this->userService->destroy($user->id);
    }

}
