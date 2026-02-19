<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateShopRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'shop_name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'product_type' => 'required|string|max:255',
            'business_type' => ['required', 'string', Rule::in(\App\Models\Shop::getBusinessTypes())],
            'omset_min' => 'nullable|string',
            'omset_max' => 'nullable|string',
            'logo' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'delete_logo' => 'nullable|boolean',
        ];
    }

    public function messages(): array
    {
        return [
            'shop_name.required' => translate('Nama toko wajib diisi.'),
            'shop_name.max' => translate('Nama toko maksimal 255 karakter.'),
            'product_type.required' => translate('Jenis produk wajib diisi.'),
            'business_type.required' => translate('Jenis usaha wajib dipilih.'),
            'business_type.in' => translate('Jenis usaha tidak valid.'),
            'logo.image' => translate('File harus berupa gambar.'),
            'logo.mimes' => translate('Format gambar harus jpg, jpeg, png, atau webp.'),
            'logo.max' => translate('Ukuran logo maksimal 2MB.'),
        ];
    }
}
