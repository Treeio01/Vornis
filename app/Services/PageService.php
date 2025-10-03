<?php

namespace App\Services;

use App\Data\AddressData;
use App\Enums\AddressStatus;
use App\Models\User;

class PageService
{
    public function __construct(
        private readonly SettingsService $settingsService,
        private readonly AddressService $addressService,
    ) {
    }

    public function landing(): array
    {
        $settings = $this->settingsService->get();

        return [
            'twitter' => $settings->twitter,
            'text' => $settings->text,
        ];
    }

    public function dashboard(): array
    {
        $settings = $this->settingsService->get();

        return [
            'twitter' => $settings->twitter,
            'addresses' => AddressData::collection(
                $this->addressService->getAll()
            ),
        ];
    }

    public function myReports(User $user): array
    {
        $settings = $this->settingsService->get();

        return [
            'twitter' => $settings->twitter,
            'addresses' => AddressData::collection(
                $this->addressService->getForUser($user)
            ),
        ];
    }

    public function publicList(): array
    {
        $settings = $this->settingsService->get();

        return [
            'twitter' => $settings->twitter,
            'addresses' => AddressData::collection(
                $this->addressService->getByStatus(AddressStatus::Scam)
            ),
        ];
    }

    public function earnings(User $user): array
    {
        $settings = $this->settingsService->get();

        return [
            'twitter' => $settings->twitter,
            'addresses' => AddressData::collection(
                $this->addressService
                    ->getForUserByStatus($user, AddressStatus::Scam)
            ),
        ];
    }
}
