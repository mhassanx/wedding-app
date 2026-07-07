<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class SiteSetting extends Model
{
    protected $fillable = ['key', 'value'];

    public static function get(string $key, mixed $default = null): mixed
    {
        return Cache::rememberForever("setting:{$key}", function () use ($key, $default) {
            $row = self::where('key', $key)->first();

            return $row ? $row->value : $default;
        });
    }

    public static function set(string $key, mixed $value): void
    {
        self::updateOrCreate(['key' => $key], ['value' => $value]);
        Cache::forget("setting:{$key}");
    }

    public static function getMany(array $keysWithDefaults): array
    {
        $result = [];

        foreach ($keysWithDefaults as $key => $default) {
            $result[$key] = self::get($key, $default);
        }

        return $result;
    }
}
