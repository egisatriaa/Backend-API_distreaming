<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateMovieRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // route sudah dilindungi middleware 'admin'
    }

    public function rules(): array
    {
        return [
            'title' => 'sometimes|required|string|max:255',
            'description' => 'nullable|string',
            'release_year' => 'sometimes|required|integer|min:1888|max:' . date('Y'),
            'duration_minutes' => 'sometimes|required|integer|min:10',
            'poster_url' => 'nullable|url|max:1000',
            'category_ids' => 'sometimes|required|array|min:1',
            'category_ids.*' => 'sometimes|required|integer|exists:categories,id',
        ];
    }

    public function messages(): array
    {
        return [
            'title.required' => 'Judul film wajib diisi jika disediakan.',
            'title.string' => 'Judul film harus berupa teks.',
            'title.max' => 'Judul film maksimal 255 karakter.',
            
            'release_year.required' => 'Tahun rilis wajib diisi jika disediakan.',
            'release_year.integer' => 'Tahun rilis harus berupa angka.',
            'release_year.min' => 'Tahun rilis minimal 1888.',
            'release_year.max' => 'Tahun rilis tidak boleh di masa depan.',
            
            'duration_minutes.required' => 'Durasi film wajib diisi jika disediakan.',
            'duration_minutes.integer' => 'Durasi harus berupa angka (menit).',
            'duration_minutes.min' => 'Durasi minimal 10 menit.',
            
            'poster_url.url' => 'URL poster harus valid.',
            'poster_url.max' => 'URL poster maksimal 1000 karakter.',
            
            'category_ids.required' => 'Jika mengupdate kategori, minimal pilih satu.',
            'category_ids.array' => 'Kategori harus berupa daftar.',
            'category_ids.min' => 'Pilih minimal satu kategori.',
            'category_ids.*.exists' => 'Beberapa kategori tidak valid.',
        ];
    }
}