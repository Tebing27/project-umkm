<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules;

class UpdatePasswordRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'current_password' => ['required', 'current_password'],
            'password' => ['required', 'confirmed', Rules\Password::min(8)->mixedCase()->numbers()],
        ];
    }

    public function messages(): array
    {
        return [
            'current_password.required' => translate('Password saat ini wajib diisi.'),
            'current_password.current_password' => translate('Password saat ini tidak sesuai.'),
            'password.required' => translate('Password baru wajib diisi.'),
            'password.confirmed' => translate('Konfirmasi password tidak cocok.'),
            'password.min' => translate('Password minimal 8 karakter.'),
        ];
    }
}
