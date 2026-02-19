<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRegionDetailsRequest extends FormRequest
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
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => translate('Nama wilayah wajib diisi.'),
            'name.max' => translate('Nama wilayah maksimal 255 karakter.'),
            'latitude.numeric' => translate('Latitude harus berupa angka.'),
            'longitude.numeric' => translate('Longitude harus berupa angka.'),
        ];
    }
}
