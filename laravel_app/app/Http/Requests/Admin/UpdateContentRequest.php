<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class UpdateContentRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $rules = [
            'value' => 'nullable',
            'image' => 'nullable|image|max:5048',
        ];

        $content = $this->route('content') ?? \App\Models\Content::find($this->route('id'));
        
        if ($content && $content->group === 'business_types') {
            $rules['icon'] = 'nullable|file|mimes:svg|max:1024';
            $rules['logo_fallback'] = 'nullable|file|mimes:svg|max:1024';
        }

        return $rules;
    }

    public function messages(): array
    {
        return [
            'image.image' => translate('File harus berupa gambar.'),
            'image.max' => translate('Ukuran gambar maksimal 5MB.'),
            'icon.mimes' => translate('Icon harus berformat SVG.'),
            'icon.max' => translate('Ukuran icon maksimal 1MB.'),
            'logo_fallback.mimes' => translate('Logo harus berformat SVG.'),
            'logo_fallback.max' => translate('Ukuran logo maksimal 1MB.'),
        ];
    }
}
