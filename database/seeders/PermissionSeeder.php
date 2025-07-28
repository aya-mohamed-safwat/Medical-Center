<?php

namespace Database\Seeders;

use App\Models\Permission;
use Illuminate\Database\Seeder;

class PermissionSeeder extends Seeder
{
    public function run(): void
    {
        $permissions = [
            'create-users'   , 'update-users'     , 'delete-users'  , 'view-users',
            'update-admin'   , 'changePass-admin' , 'view-admin'    ,
            'update-client'  , 'delete-client'    , 'view-client'   ,
            'create-doctors' , 'update-doctors'   , 'delete-doctors', 'view-doctors',

            'create-schedules'    , 'update-schedules'    , 'delete-schedules'    , 'view-schedules'   ,
            'create-specialities' , 'update-specialities' , 'delete-specialities' , 'view-specialities',
            'create-services'     , 'update-services'     , 'delete-services'     , 'view-services'    ,

            'update-sessions' , 'delete-sessions' , 'view-sessions',

            'create-offers'    , 'update-offers'    , 'delete-offers'    , 'view-offers'   ,
            'create-discounts' , 'update-discounts' , 'delete-discounts' , 'view-discounts',

            'create-sliders'     , 'update-sliders'     , 'delete-sliders'     , 'view-sliders'    ,
            'create-staticPages' , 'update-staticPages' , 'delete-staticPages' , 'view-staticPages',
            'create-files'       , 'update-files'       , 'delete-files'       , 'view-files'      ,

            'create-comment'       , 'update-comment'     , 'delete-comment'       , 'view-comment'      ,

            'create-notifications', 'update-notifications', 'delete-notifications', 'view-notifications',

            'create-roles', 'update-roles', 'delete-roles', 'view-roles',

            'update-settings',

            'active'
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }
    }
}
