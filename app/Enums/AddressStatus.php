<?php

namespace App\Enums;

enum AddressStatus: string
{
    case Pending = 'pending';
    case Verified = 'verified';
    case Scam = 'scam';

    public function label(): string
    {
        return match ($this) {
            self::Pending => __('Pending'),
            self::Verified => __('Verified'),
            self::Scam => __('Scam'),
        };
    }

    public function color(): string
    {
        return match ($this) {
            self::Pending => 'warning',
            self::Verified => 'success',
            self::Scam => 'danger',
        };
    }

    /**
     * @return array<int, string>
     */
    public static function values(): array
    {
        return array_map(
            static fn (self $status): string => $status->value,
            self::cases()
        );
    }

    /**
     * @return array<string, string>
     */
    public static function options(): array
    {
        return array_reduce(
            self::cases(),
            static function (array $carry, self $status): array {
                $carry[$status->value] = $status->label();

                return $carry;
            },
            []
        );
    }

    /**
     * @return array<string, array<int, string>>
     */
    public static function colorMap(): array
    {
        return array_reduce(
            self::cases(),
            static function (array $carry, self $status): array {
                $carry[$status->color()][] = $status->value;

                return $carry;
            },
            []
        );
    }
}
