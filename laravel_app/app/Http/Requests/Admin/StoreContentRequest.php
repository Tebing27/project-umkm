<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class StoreContentRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'key' => 'required|unique:contents,key',
            'value' => 'nullable',
            'type' => 'required|in:text,textarea,editor,image',
            'group' => 'nullable|string',
            'label' => 'nullable|string',
            'image' => 'nullable|image|max:5048',
            'icon' => 'nullable|file|mimes:svg|max:1024',
            'logo_fallback' => 'nullable|file|mimes:svg|max:1024',
        ];
    }

    public function messages(): array
    {
        return [
            'key.required' => translate('Key wajib diisi.'),
            'key.unique' => translate('Key sudah digunakan.'),
            'type.required' => translate('Tipe konten wajib dipilih.'),
            'type.in' => translate('Tipe konten tidak valid.'),
            'image.image' => translate('File harus berupa gambar.'),
            'image.max' => translate('Ukuran gambar maksimal 5MB.'),
            'icon.mimes' => translate('Icon harus berformat SVG.'),
            'icon.max' => translate('Ukuran icon maksimal 1MB.'),
            'logo_fallback.mimes' => translate('Logo harus berformat SVG.'),
            'logo_fallback.max' => translate('Ukuran logo maksimal 1MB.'),
        ];
    }
}
