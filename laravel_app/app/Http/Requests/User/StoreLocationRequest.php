<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

class StoreLocationRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
            'address' => 'nullable|string',
            'region_id' => 'required|exists:regions,id',
        ];
    }

    public function messages(): array
    {
        return [
            'latitude.required' => translate('Latitude wajib diisi.'),
            'latitude.numeric' => translate('Latitude harus berupa angka.'),
            'longitude.required' => translate('Longitude wajib diisi.'),
            'longitude.numeric' => translate('Longitude harus berupa angka.'),
            'region_id.required' => translate('Wilayah wajib dipilih.'),
            'region_id.exists' => translate('Wilayah tidak ditemukan.'),
        ];
    }
}
