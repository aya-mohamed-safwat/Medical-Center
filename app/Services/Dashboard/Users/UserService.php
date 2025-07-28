<?php

namespace App\Services\Dashboard\Users;

use App\Http\Resources\Dashboard\Users\UserResource;
use App\Models\User;
use App\Services\BaseServices\BaseService;

class UserService extends BaseService
{
    protected $model    = User::class;
    protected $resource = UserResource::class;

}
