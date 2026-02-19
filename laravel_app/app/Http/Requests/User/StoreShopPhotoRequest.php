<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

class StoreShopPhotoRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'photos.*' => 'image|max:2048',
            'delete_ids' => 'nullable|array',
            'delete_ids.*' => 'exists:shop_photos,id',
        ];
    }

    public function messages(): array
    {
        return [
            'photos.*.image' => translate('File harus berupa gambar.'),
            'photos.*.max' => translate('Ukuran gambar maksimal 2MB.'),
            'delete_ids.array' => translate('Format ID hapus tidak valid.'),
            'delete_ids.*.exists' => translate('Foto tidak ditemukan.'),
        ];
    }
}
