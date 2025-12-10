<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreWatchHistoryRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'is_completed' => 'nullable|boolean',
        ];
    }

    public function messages(): array
    {
        return [
            'is_completed.boolean' => 'Status selesai harus berupa true/false.',
        ];
    }
}