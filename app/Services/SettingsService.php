<?php

namespace App\Services;

use App\Models\Settings;
use Illuminate\Support\Facades\Cache;

class SettingsService
{
    private const CACHE_KEY = 'settings.singleton';
    private const CACHE_TTL = 300;

    public function get(): Settings
    {
        return Cache::remember(self::CACHE_KEY, self::CACHE_TTL, function () {
            $settings = Settings::query()->first();

            if ($settings) {
                return $settings;
            }

            return new Settings([
                'twitter' => config('app.url'),
                'text' => 'Configure platform text via admin panel.',
            ]);
        });
    }

    public function refreshCache(): void
    {
        Cache::forget(self::CACHE_KEY);
    }
}
