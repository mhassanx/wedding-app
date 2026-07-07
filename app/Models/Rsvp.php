<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Builder;

class Rsvp extends Model
{
    protected $fillable = [
        'guest_id',
        'name',
        'guest_count',
        'message',
    ];

    protected $casts = [
        'guest_count' => 'integer',
    ];

    public static function createFromRequest(array $data): self
    {
        $guest = null;

        if (! empty($data['invite_code'])) {
            $guest = Guest::where('invite_code', $data['invite_code'])->first();
        }

        return static::create([
            'guest_id' => $guest?->id,
            'name' => $data['name'],
            'guest_count' => $data['guest_count'],
            'message' => $data['message'] ?? null,
        ])->load('guest');
    }

    public function guest(): BelongsTo
    {
        return $this->belongsTo(Guest::class);
    }

    public function scopeLatest(Builder $query): Builder
    {
        return $query->orderByDesc('created_at');
    }
}
