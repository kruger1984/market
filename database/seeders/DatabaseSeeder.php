<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Enums\Role\RoleEnum;
use App\Models\Role;
use App\Models\User;
use Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $user = [
            'name' => 'admin',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('admin@gmail.com'),
            'email_verified_at' => now(),
        ];

        $user = User::query()->firstOrCreate(['email' => $user['email']], $user);

        $role = Role::query()->firstOrCreate(['title' => RoleEnum::Admin->value]);
        $user->roles()->sync([$role->id]);
    }
}
