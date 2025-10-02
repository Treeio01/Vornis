<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;

class MakeUserAdmin extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'user:make-admin {user_id : ID пользователя для назначения админом}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Назначает пользователя администратором';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $userId = $this->argument('user_id');
        
        $user = User::find($userId);
        
        if (!$user) {
            $this->error("Пользователь с ID {$userId} не найден!");
            return 1;
        }
        
        $user->update([
            'role' => 'admin',
            'name' => $user->name ?? 'Admin'
        ]);
        
        $this->info("Пользователь {$user->email} (ID: {$user->id}) назначен администратором!");
        
        return 0;
    }
}