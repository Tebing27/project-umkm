<?php

namespace App\Http\Requests\Auth;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules;

class RegistrationRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:' . User::class],
            'password' => ['required', 'confirmed', Rules\Password::min(8)->mixedCase()->numbers()],
            'phone_number' => ['required', 'string', 'max:20'],
            'place_of_birth' => ['required', 'string', 'max:100'],
            'date_of_birth' => ['required', 'date'],
            'domicile_address' => ['required', 'string'],
            'shop_name' => ['required', 'string', 'max:255'],
            'product_type' => ['required', 'string', 'max:255'],
            'business_type' => ['required', 'string', 'max:255'],
            'shop_address' => ['required', 'string'],
            'latitude' => ['nullable', 'numeric'],
            'longitude' => ['nullable', 'numeric'],
            'region_id' => ['required', 'exists:regions,id'],
            'license_type.*' => ['nullable', 'string'],
            'license_number.*' => ['nullable', 'string'],
            'social_instagram' => ['nullable', 'url'],
            'social_tiktok' => ['nullable', 'url'],
            'social_facebook' => ['nullable', 'url'],
            'social_website' => ['nullable', 'url'],
        ];
    }

    public function messages(): array
    {
        return [
            'required' => translate(':attribute wajib diisi.'),
            'string' => translate(':attribute harus berupa teks.'),
            'numeric' => translate(':attribute harus berupa angka.'),
            'email' => translate(':attribute harus berupa email yang valid.'),
            'max' => translate(':attribute tidak boleh lebih dari :max karakter.'),
            'unique' => translate(':attribute sudah terdaftar.'),
            'confirmed' => translate('Konfirmasi :attribute tidak cocok.'),
            'date' => translate(':attribute bukan tanggal yang valid.'),
            'url' => translate(':attribute harus berupa URL yang valid (awali dengan http:// atau https://).'),
        ];
    }

    public function attributes(): array
    {
        return [
            'name' => translate('Nama Pemilik'),
            'email' => translate('Email'),
            'password' => translate('Kata Sandi'),
            'phone_number' => translate('Nomor Handphone'),
            'place_of_birth' => translate('Tempat Lahir'),
            'date_of_birth' => translate('Tanggal Lahir'),
            'domicile_address' => translate('Alamat Domisili'),
            'shop_name' => translate('Nama Usaha'),
            'product_type' => translate('Jenis Produk'),
            'business_type' => translate('Jenis Usaha'),
            'shop_address' => translate('Alamat Usaha'),
            'latitude' => translate('Latitude'),
            'longitude' => translate('Longitude'),
            'region_id' => translate('Wilayah'),
        ];
    }
}
