<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateSiteSettingsRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $maxImageSize = config('wedding.share_image.max_size_kb');

        return [
            'bride_name' => ['required', 'string', 'max:255'],
            'groom_name' => ['required', 'string', 'max:255'],
            'mehndi_date' => ['required', 'string', 'max:100'],
            'mehndi_time' => ['required', 'string', 'max:50'],
            'mehndi_venue' => ['required', 'string', 'max:255'],
            'nikah_date' => ['required', 'string', 'max:100'],
            'nikah_time' => ['required', 'string', 'max:50'],
            'nikah_venue' => ['required', 'string', 'max:255'],
            'walima_date' => ['required', 'string', 'max:100'],
            'walima_time' => ['required', 'string', 'max:50'],
            'walima_venue' => ['required', 'string', 'max:255'],
            'countdown_target' => ['required', 'string', 'max:50'],
            'contact_name_1' => ['nullable', 'string', 'max:255'],
            'contact_phone_1' => ['nullable', 'string', 'max:50'],
            'contact_name_2' => ['nullable', 'string', 'max:255'],
            'contact_phone_2' => ['nullable', 'string', 'max:50'],
            'bank_accounts' => ['nullable', 'array'],
            'bank_accounts.*.account_name' => ['required', 'string', 'max:255'],
            'bank_accounts.*.account_holder_name' => ['nullable', 'string', 'max:255'],
            'bank_accounts.*.account_number' => ['nullable', 'string', 'max:255'],
            'bank_accounts.*.iban' => ['nullable', 'string', 'max:255'],
            'bank_accounts.*.sort_order' => ['nullable', 'integer', 'min:0'],
            'share_image' => ['nullable', 'image', 'max:'.$maxImageSize],
            'use_default_share_image' => ['nullable', 'boolean'],
        ];
    }

    public function settingAttributes(): array
    {
        return collect($this->validated())
            ->except(['bank_accounts', 'share_image', 'use_default_share_image'])
            ->all();
    }

    public function bankAccounts(): array
    {
        return $this->input('bank_accounts', []);
    }

    public function shouldUseDefaultShareImage(): bool
    {
        return $this->boolean('use_default_share_image');
    }
}
