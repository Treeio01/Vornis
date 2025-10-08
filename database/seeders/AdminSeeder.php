<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $email = config('seeders.admin.email', env('ADMIN_SEED_EMAIL'));
        $password = config('seeders.admin.password', env('ADMIN_SEED_PASSWORD'));

        if (! $email || ! $password) {
            $this->command?->warn('ADMIN_SEED_EMAIL/ADMIN_SEED_PASSWORD не заданы — сидер пропущен.');
            return;
        }

        if (User::where('email', $email)->exists()) {
            $this->command?->warn("Пользователь {$email} уже существует. Сидер пропущен.");

            return;
        }

        User::create([
            'name' => 'Admin',
            'email' => $email,
            'password' => Hash::make($password),
            'role' => 'admin',
            'balance' => 0,
        ]);

        $this->command?->info("Администратор создан: {$email}");
    }
}
