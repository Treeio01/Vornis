<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class Settings extends Model
{
    use HasFactory;

    protected $fillable = [
        'twitter',
        'text'
    ];

    protected static function booted(): void
    {
        static::saved(fn () => Cache::forget('settings.singleton'));
        static::deleted(fn () => Cache::forget('settings.singleton'));
    }
}
