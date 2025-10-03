<?php

namespace App\Services;

use App\Enums\AddressStatus;
use App\Models\Address;
use App\Models\User;
use Illuminate\Support\Collection;

class AddressService
{
    public function storeForUser(User $user, array $payload): Address
    {
        return Address::create([
            'user_id' => $user->id,
            'address' => $payload['address'],
            'token' => $payload['token'],
            'comment' => $payload['comment'] ?? null,
            'status' => AddressStatus::Pending,
        ]);
    }

    public function getAll(): Collection
    {
        return Address::all();
    }

    public function getForUser(User $user): Collection
    {
        return Address::where('user_id', $user->id)->get();
    }

    public function getByStatus(AddressStatus $status): Collection
    {
        return Address::where('status', $status->value)->get();
    }

    public function getForUserByStatus(User $user, AddressStatus $status): Collection
    {
        return Address::where('user_id', $user->id)
            ->where('status', $status->value)
            ->get();
    }
}
