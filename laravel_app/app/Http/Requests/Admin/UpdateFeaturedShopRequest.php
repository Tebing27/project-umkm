<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class UpdateFeaturedShopRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'shop_id' => 'nullable|exists:shops,id',
            'hero_order' => 'nullable|integer|min:0',
        ];
    }

    public function messages(): array
    {
        return [
            'shop_id.exists' => translate('Toko tidak ditemukan.'),
            'hero_order.integer' => translate('Urutan harus berupa angka bulat.'),
            'hero_order.min' => translate('Urutan minimal 0.'),
        ];
    }
}
