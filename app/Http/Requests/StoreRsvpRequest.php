<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreRsvpRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'guest_count' => ['required', 'integer', 'min:1', 'max:20'],
            'message' => ['nullable', 'string', 'max:1000'],
            'invite_code' => ['nullable', 'string', 'max:20'],
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Please tell us your name.',
            'guest_count.required' => 'Please tell us how many guests are attending.',
            'guest_count.min' => 'Guest count must be at least 1.',
        ];
    }
}
