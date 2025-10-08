<?php

namespace App\Services;

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

    public function dashboard(User $user): array
    {
        $settings = $this->settingsService->get();

        return [
            'twitter' => $settings->twitter,
            'addresses' => $this->addressService->paginateAll(),
            'recentUserAddresses' => $this->addressService->recentForUser($user),
            'stats' => $this->addressService->dashboardStats($user),
        ];
    }

    public function myReports(User $user): array
    {
        $settings = $this->settingsService->get();

        return [
            'twitter' => $settings->twitter,
            'addresses' => $this->addressService->paginateForUser($user),
        ];
    }

    public function publicList(): array
    {
        $settings = $this->settingsService->get();

        return [
            'twitter' => $settings->twitter,
            'addresses' => $this->addressService->paginateScam(),
        ];
    }

    public function earnings(User $user): array
    {
        $settings = $this->settingsService->get();

        return [
            'twitter' => $settings->twitter,
            'addresses' => $this->addressService
                ->paginateForUser($user, status: AddressStatus::Scam),
        ];
    }
}
