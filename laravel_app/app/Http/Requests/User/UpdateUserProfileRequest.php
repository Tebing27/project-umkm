<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateUserProfileRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($this->user()->id)],
            'phone_number' => ['required', 'string', 'max:20'],
            'place_of_birth' => ['nullable', 'string', 'max:100'],
            'date_of_birth' => ['nullable', 'date'],
            'domicile_address' => ['nullable', 'string', 'max:500'],
            'current_password' => ['required', 'current_password'],
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => translate('Nama wajib diisi.'),
            'name.max' => translate('Nama maksimal 255 karakter.'),
            'email.required' => translate('Email wajib diisi.'),
            'email.email' => translate('Email tidak valid.'),
            'email.unique' => translate('Email sudah digunakan.'),
            'phone_number.required' => translate('Nomor telepon wajib diisi.'),
            'phone_number.max' => translate('Nomor telepon maksimal 20 karakter.'),
            'current_password.required' => translate('Password saat ini wajib diisi.'),
            'current_password.current_password' => translate('Password saat ini tidak sesuai.'),
        ];
    }
}
