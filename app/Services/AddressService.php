<?php

namespace App\Services;

use App\Data\AddressData;
use App\Enums\AddressStatus;
use App\Models\Address;
use App\Models\User;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
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

    /**
     * Пагинация всех адресов для модераторов.
     */
    public function paginateAll(int $perPage = 25): LengthAwarePaginator
    {
        return Address::query()
            ->latest('created_at')
            ->paginate($perPage)
            ->withQueryString()
            ->through(fn (Address $address) => AddressData::fromModel($address)->toArray());
    }

    /**
     * Пагинация адресов конкретного пользователя.
     */
    public function paginateForUser(User $user, int $perPage = 25, ?AddressStatus $status = null): LengthAwarePaginator
    {
        $query = Address::query()
            ->where('user_id', $user->id)
            ->latest('created_at');

        if ($status) {
            $query->where('status', $status->value);
        }

        return $query
            ->paginate($perPage)
            ->withQueryString()
            ->through(fn (Address $address) => AddressData::fromModel($address)->toArray());
    }

    /**
     * Пагинация публичного списка (SCAM).
     */
    public function paginateScam(int $perPage = 25): LengthAwarePaginator
    {
        return Address::query()
            ->where('status', AddressStatus::Scam->value)
            ->latest('created_at')
            ->paginate($perPage)
            ->withQueryString()
            ->through(fn (Address $address) => AddressData::fromModel($address)->toArray());
    }

    /**
     * Статистика для дашборда текущего пользователя.
     */
    public function dashboardStats(User $user): array
    {
        $userAddresses = Address::query()->where('user_id', $user->id);

        $userTotal = (clone $userAddresses)->count();
        $userVerified = (clone $userAddresses)->where('status', AddressStatus::Verified->value)->count();
        $userPending = (clone $userAddresses)->where('status', AddressStatus::Pending->value)->count();
        $totalScam = Address::query()->where('status', AddressStatus::Scam->value)->count();

        return [
            'my_submissions' => $userTotal,
            'my_verified' => $userVerified,
            'my_pending' => $userPending,
            'total_scam' => $totalScam,
        ];
    }

    /**
     * Последние репорты пользователя (для блока активности).
     *
     * @return array<int, array<string, mixed>>
     */
    public function recentForUser(User $user, int $limit = 5): array
    {
        return Address::query()
            ->where('user_id', $user->id)
            ->latest('created_at')
            ->limit($limit)
            ->get()
            ->map(fn (Address $address) => AddressData::fromModel($address)->toArray())
            ->all();
    }

    /**
     * Легаси-методы сохранены для обратной совместимости.
     * Планируется удалить после полной миграции на пагинацию.
     */
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
