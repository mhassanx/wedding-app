<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Str;

class Guest extends Model
{
    protected $fillable = [
        'name',
        'invite_code',
        'opened_at',
    ];

    protected $casts = [
        'opened_at' => 'datetime',
    ];

    protected static function booted(): void
    {
        static::creating(function (Guest $guest) {
            if (empty($guest->invite_code)) {
                $guest->invite_code = self::generateUniqueCode();
            }
        });
    }

    public static function generateUniqueCode(): string
    {
        do {
            $code = Str::lower(Str::random(8));
        } while (self::where('invite_code', $code)->exists());

        return $code;
    }

    public function markAsOpened(): void
    {
        if ($this->opened_at) {
            return;
        }

        $this->update(['opened_at' => now()]);
    }

    public function rsvp(): HasOne
    {
        return $this->hasOne(Rsvp::class);
    }

    public function scopeLatest(Builder $query): Builder
    {
        return $query->orderByDesc('created_at');
    }
}
