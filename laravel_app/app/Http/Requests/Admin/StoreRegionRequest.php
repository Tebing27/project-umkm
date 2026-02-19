<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class StoreRegionRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
            'image' => 'required|image|max:2048',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => translate('Nama wilayah wajib diisi.'),
            'name.max' => translate('Nama wilayah maksimal 255 karakter.'),
            'latitude.numeric' => translate('Latitude harus berupa angka.'),
            'longitude.numeric' => translate('Longitude harus berupa angka.'),
            'image.required' => translate('Gambar wilayah wajib diunggah.'),
            'image.image' => translate('File harus berupa gambar.'),
            'image.max' => translate('Ukuran gambar maksimal 2MB.'),
        ];
    }
}
