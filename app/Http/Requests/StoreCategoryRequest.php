<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCategoryRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'category_name' => 'required|string|max:100|unique:categories,category_name',
            'description' => 'nullable|string',
        ];
    }

    public function messages(): array
    {
        return [
            'category_name.required' => 'Nama kategori wajib diisi.',
            'category_name.string' => 'Nama kategori harus berupa teks.',
            'category_name.max' => 'Nama kategori maksimal 100 karakter.',
            'category_name.unique' => 'Kategori ini sudah ada.',
        ];
    }
}