<?php

namespace App\Services\Dashboard\Roles;

use App\Http\Requests\dashboard\Roles\PermissionRequest;
use App\Http\Resources\Dashboard\Roles\RoleResource;
use App\Models\Role;
use App\Services\BaseServices\BaseService;
use Illuminate\Http\JsonResponse;
use function App\Helpers\json;

class RoleService extends BaseService
{
 protected $model = Role::class;
 protected $resource = RoleResource::class;

 public function updatePermissions($roleId , PermissionRequest $request): JsonResponse
 {
     $permissionsId = $request->input('permissions');
     $role = Role::findOrFail($roleId);
     $role->permissions()->sync(array_values($permissionsId));
     return json(__('response.success') , __('response.done.update') ,'' ,200);
 }
}
