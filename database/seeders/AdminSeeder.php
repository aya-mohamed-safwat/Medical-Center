<?php

namespace Database\Seeders;

use App\Models\AdminProfile;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{

    public function run(): void
    {
        $user = User::create([
            'name' => 'admin',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('12345678'),
            'role_id' => 1,
        ]);

        AdminProfile::create([
            'user_id' => $user->id,
        ]);
    }
}
