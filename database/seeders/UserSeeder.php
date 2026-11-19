<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $defaultAvatar = '/uploads/avatar.png';

        User::updateOrCreate(
            ['email' => 'admin@gmail.com'],
            [
                'name' => 'Admin',
                'firstname' => 'Administrateur',
                'lastname' => 'Admin',
                'role' => 'admin',
                'password' => Hash::make('12345678'),
                'avatar' => $defaultAvatar,
                'is_active' => true,
            ]
        );

        User::updateOrCreate(
            ['email' => 'user@gmail.com'],
            [
                'name' => 'User',
                'firstname' => 'Utilisateur',
                'lastname' => 'User',
                'role' => 'user',
                'password' => Hash::make('12345678'),
                'avatar' => $defaultAvatar,
                'is_active' => true,
            ]
        );
    }
}
