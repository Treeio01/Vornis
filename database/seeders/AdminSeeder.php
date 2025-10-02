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
        // Создаем админа если его еще нет
        if (!User::where('email', 'admin@vornis.com')->exists()) {
            User::create([
                'name' => 'Admin',
                'email' => 'admin@vornis.com',
                'password' => Hash::make('password'),
                'role' => 'admin',
                'balance' => 0,
            ]);
            
            $this->command->info('Администратор создан: admin@vornis.com / password');
        } else {
            $this->command->info('Администратор уже существует');
        }
    }
}