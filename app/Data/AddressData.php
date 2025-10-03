<?php

namespace App\Data;

use App\Enums\AddressStatus;
use App\Models\Address;

class AddressData
{
    public function __construct(
        public readonly int $id,
        public readonly string $address,
        public readonly AddressStatus $status,
        public readonly string $token,
        public readonly ?string $comment,
        public readonly ?string $remark,
        public readonly ?string $reward,
        public readonly int $userId,
        public readonly ?string $createdAt,
        public readonly ?string $updatedAt,
        public readonly ?string $createdDate,
        public readonly ?string $createdTime,
        public readonly ?string $updatedDate,
        public readonly ?string $updatedTime,
    ) {
    }

    public static function fromModel(Address $address): self
    {
        return new self(
            id: $address->id,
            address: $address->address,
            status: $address->status instanceof AddressStatus
                ? $address->status
                : AddressStatus::from($address->status),
            token: $address->token,
            comment: $address->comment,
            remark: $address->remark,
            reward: $address->reward,
            userId: $address->user_id,
            createdAt: optional($address->created_at)?->toDateTimeString(),
            updatedAt: is_string($address->updated_at)
                ? $address->updated_at
                : optional($address->updated_at)?->toDateTimeString(),
            createdDate: $address->created_date,
            createdTime: $address->created_time,
            updatedDate: $address->updated_date,
            updatedTime: $address->updated_time,
        );
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'address' => $this->address,
            'status' => $this->status->value,
            'status_label' => $this->status->label(),
            'status_color' => $this->status->color(),
            'token' => $this->token,
            'comment' => $this->comment,
            'remark' => $this->remark,
            'reward' => $this->reward,
            'user_id' => $this->userId,
            'created_at' => $this->createdAt,
            'updated_at' => $this->updatedAt,
            'created_date' => $this->createdDate,
            'created_time' => $this->createdTime,
            'updated_date' => $this->updatedDate,
            'updated_time' => $this->updatedTime,
        ];
    }

    public static function collection(iterable $addresses): array
    {
        return collect($addresses)
            ->map(fn (Address $address) => self::fromModel($address)->toArray())
            ->all();
    }
}
