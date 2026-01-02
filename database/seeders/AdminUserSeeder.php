<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name' => 'DevCleon',
            'email' => 'hello@devcleon.site',
            'password' => Hash::make('password'),
            'role' => 'admin',
            'discipline_score' => 85.5,
        ]);

        $this->command->info('Admin user created successfully!');
        $this->command->info('Email: hello@devcleon.site');
        $this->command->info('Password: password');
    }
}
