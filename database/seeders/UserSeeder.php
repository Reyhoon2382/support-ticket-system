<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Enums\UserRoleEnum;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        
        User::create([
            'name' => 'System Admin',
            'email' => 'admin@example.com',
            'password' => Hash::make('password'),
            'role' => UserRoleEnum::ADMIN->value,
        ]);

        User::create([
            'name' => 'Support Manager',
            'email' => 'manager@example.com',
            'password' => Hash::make('password'),
            'role' => UserRoleEnum::SUPPORT_MANAGER->value,
        ]);

        User::create([
            'name' => 'Expert One',
            'email' => 'expert@example.com',
            'password' => Hash::make('password'),
            'role' => UserRoleEnum::EXPERT->value,
        ]);

        User::create([
            'name' => 'Customer One',
            'email' => 'customer@example.com',
            'password' => Hash::make('password'),
            'role' => UserRoleEnum::CUSTOMER->value,
        ]);
    }

}
