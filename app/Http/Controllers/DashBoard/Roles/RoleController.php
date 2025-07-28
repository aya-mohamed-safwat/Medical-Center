<?php

namespace App\Http\Controllers\DashBoard\Roles;

use App\Http\Middleware\CheckPermission;
use App\Http\Requests\dashboard\Active\IndexRequest;
use App\Http\Requests\dashboard\Roles\PermissionRequest;
use App\Http\Requests\dashboard\Roles\RoleRequest;
use App\Services\Dashboard\Roles\RoleService;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;

class RoleController extends Controller
{
    public function __construct(protected RoleService $roleService)
    {
        $this->middleware(CheckPermission::class .':create-roles')->only(['store']);
        $this->middleware(CheckPermission::class .':update-roles')->only(['update']);
        $this->middleware(CheckPermission::class .':delete-roles')->only(['destroy']);
        $this->middleware(CheckPermission::class .':view-roles')->only(['show' , 'index']);
    }

    public function index(IndexRequest $request): JsonResponse
    {
        return $this->roleService->index($request);
    }

    public function show($id): JsonResponse
    {
        return $this->roleService->show($id);
    }

    public function store(RoleRequest $request): JsonResponse
    {
        return $this->roleService->store($request->validated());
    }

    public function update(RoleRequest $request, int $id): JsonResponse
    {
        return $this->roleService->update($id, $request->validated());
    }

    public function updatePermissions(PermissionRequest $request, int $roleId): JsonResponse
    {
        return $this->roleService->updatePermissions($roleId, $request);
    }

    public function destroy(int $id): JsonResponse
    {
        return $this->roleService->destroy($id);
    }


}
