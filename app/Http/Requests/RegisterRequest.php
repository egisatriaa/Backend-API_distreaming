<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
{

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'username' => 'required|string|max:50|min:3|unique:users',
            'email' => 'required|string|email|max:100|unique:users',
            'password' => 'required|string|max:255|min:8'
        ];
    }
    ///       
// client    ====== admin CRUD admin
//           ====== user READ
    public function messages(): array
{
    return [
        'username.required' => 'Username wajib diisi',
        'username.string' => 'Username harus berupa teks',
        'username.max' => 'Username maksimal 50 karakter',
        'username.min' => 'Username minimal 3 karakter',
        'username.unique' => 'Username sudah digunakan',

        'email.required' => 'Email wajib diisi',
        'email.string' => 'Email harus berupa teks',
        'email.email' => 'Format email tidak valid',
        'email.max' => 'Email maksimal 100 karakter',
        'email.unique' => 'Email sudah terdaftar',

        'password.required' => 'Password wajib diisi',
        'password.string' => 'Password harus berupa teks',
        'password.max' => 'Password maksimal 255 karakter',
        'password.min' => 'Password minimal 8 karakter'
    ];
}

}
