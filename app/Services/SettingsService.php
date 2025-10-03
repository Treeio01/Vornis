<?php

namespace App\Services;

use App\Models\Settings;

class SettingsService
{
    public function get(): Settings
    {
        return Settings::findOrFail(1);
    }
}
