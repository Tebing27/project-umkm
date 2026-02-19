<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRegionImageRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'image' => 'required|image|max:2048',
        ];
    }

    public function messages(): array
    {
        return [
            'image.required' => translate('Gambar wilayah wajib diunggah.'),
            'image.image' => translate('File harus berupa gambar.'),
            'image.max' => translate('Ukuran gambar maksimal 2MB.'),
        ];
    }
}
