<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class BankAccount extends Model
{
    protected $fillable = [
        'account_name',
        'account_holder_name',
        'account_number',
        'iban',
        'sort_order',
    ];

    protected $casts = [
        'sort_order' => 'integer',
    ];

    public static function syncFromInput(array $accounts): void
    {
        static::query()->delete();

        foreach ($accounts as $index => $accountData) {
            $accountData = array_filter($accountData, fn ($value) => $value !== null && $value !== '');

            if (empty($accountData)) {
                continue;
            }

            static::create([
                'account_name' => $accountData['account_name'] ?? '',
                'account_holder_name' => $accountData['account_holder_name'] ?? null,
                'account_number' => $accountData['account_number'] ?? '',
                'iban' => $accountData['iban'] ?? null,
                'sort_order' => $accountData['sort_order'] ?? $index,
            ]);
        }
    }

    public function scopeOrdered(Builder $query): Builder
    {
        return $query->orderBy('sort_order')->orderBy('created_at');
    }
}
