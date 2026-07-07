<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UploadGalleryImagesRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $maxImageSize = config('wedding.gallery.max_size_kb');

        return [
            'images' => ['required', 'array', 'min:1'],
            'images.*' => ['required', 'image', 'max:'.$maxImageSize],
        ];
    }

    public function messages(): array
    {
        return [
            'images.required' => 'Please select at least one image to upload.',
            'images.*.image' => 'Each file must be a valid image.',
        ];
    }
}
