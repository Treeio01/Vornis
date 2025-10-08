<?php

namespace App\Models;

use App\Enums\AddressStatus;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    use HasFactory;

    protected $fillable = [
        "address",
        "status",
        "remark",
        "reward",
        "token",
        "user_id",
        "comment"
    ];

    protected $casts = [
        'status' => AddressStatus::class,
        'reward' => 'float',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    protected function updatedAt(): Attribute
    {
        return Attribute::make(
            get: fn($value) => \Carbon\Carbon::parse($value)->format('d.m.Y H:i')
        );
    }
    protected $appends = ['updated_date', 'updated_time','created_date', 'created_time'];

    protected function createdDate(): Attribute
    {
        return Attribute::make(
            get: fn() => $this->created_at
            ? Carbon::parse($this->created_at)->format('d.m.Y')
            : null,
        );
    }
    protected function createdTime(): Attribute
    {
        return Attribute::make(
            get: fn() => $this->created_at
            ? Carbon::parse($this->created_at)->format('H:i:s')
            : null,
        );
    }
    protected function updatedDate(): Attribute
    {
        return Attribute::make(
            get: fn() => $this->updated_at
            ? Carbon::parse($this->updated_at)->format('d.m.Y')
            : null,
        );
    }

    protected function updatedTime(): Attribute
    {
        return Attribute::make(
            get: fn() => $this->updated_at
            ? Carbon::parse($this->updated_at)->format('H:i:s')
            : null,
        );
    }

    protected static function newFactory()
    {
        return \Database\Factories\AddressFactory::new();
    }
}
