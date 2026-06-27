<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Rsvp extends Model
{
    protected $fillable = [
        'guest_id',
        'name',
        'guest_count',
        'message',
    ];

    public function guest()
    {
        return $this->belongsTo(Guest::class);
    }
}
