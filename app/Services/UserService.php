<?php

namespace App\Services;

use App\Models\User;

class UserService
{
    public function connectWallet(User $user, string $walletAddress): void
    {
        $user->update([
            'address' => $walletAddress,
        ]);
    }
}
