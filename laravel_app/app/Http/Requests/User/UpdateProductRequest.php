<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class UpdateProductRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    protected function prepareForValidation(): void
    {
        if ($this->has('price')) {
            $this->merge([
                'price' => preg_replace('/[^0-9]/', '', $this->price)
            ]);
        }
    }

    public function rules(): array
    {
        $productId = $this->route('id') ?? $this->route('product');
        
        return [
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('products')->where('shop_id', Auth::user()->shop->id)->ignore($productId)
            ],
            'price' => 'required|numeric',
            'category' => 'required|string|max:255',
            'images' => 'array|max:5',
            'images.*' => 'image|max:2048',
            'delete_image_indices' => 'array',
            'variant' => 'nullable|string',
            'description' => 'nullable|string',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => translate('Nama produk wajib diisi.'),
            'name.max' => translate('Nama produk maksimal 255 karakter.'),
            'name.unique' => translate('Nama produk sudah digunakan.'),
            'price.required' => translate('Harga wajib diisi.'),
            'price.numeric' => translate('Harga harus berupa angka.'),
            'category.required' => translate('Kategori wajib dipilih.'),
            'images.max' => translate('Maksimal 5 gambar.'),
            'images.*.image' => translate('File harus berupa gambar.'),
            'images.*.max' => translate('Ukuran gambar maksimal 2MB.'),
        ];
    }
}
