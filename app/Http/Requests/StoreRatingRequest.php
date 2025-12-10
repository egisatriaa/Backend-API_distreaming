<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreRatingRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // route sudah pakai auth:sanctum
    }

    public function rules(): array
    {
        return [
            'score' => 'required|numeric|min:0|max:10',
            'review_text' => 'nullable|string|max:1000',
        ];
    }

    public function messages(): array
    {
        return [
            'score.required' => 'Nilai wajib diisi.',
            'score.numeric' => 'Nilai harus berupa angka.',
            'score.min' => 'Nilai minimal 0.0.',
            'score.max' => 'Nilai maksimal 10.0.',
            'review_text.max' => 'Ulasan maksimal 1000 karakter.',
        ];
    }
}
