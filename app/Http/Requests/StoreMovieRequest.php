<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreMovieRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        // Hanya user terautentikasi dengan role admin boleh akses
        // Tapi karena route sudah dilindungi middleware 'admin', kita return true
        return true; 
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'release_year' => 'required|integer|min:1888|max:' . date('Y'),
            'duration_minutes' => 'required|integer|min:10',
            'poster_url' => 'nullable|url|max:1000',
            'category_ids' => 'required|array|min:1',
            'category_ids.*' => 'required|integer|exists:categories,id',
        ];
    }

    public function messages(): array
    {
        return [
            'title.required' => 'Judul film wajib diisi.',
            'title.string' => 'Judul film harus berupa teks.',
            'title.max' => 'Judul film maksimal 255 karakter.',
            
            'release_year.required' => 'Tahun rilis wajib diisi.',
            'release_year.integer' => 'Tahun rilis harus berupa angka.',
            'release_year.min' => 'Tahun rilis minimal 1888.',
            'release_year.max' => 'Tahun rilis tidak boleh di masa depan.',
            
            'duration_minutes.required' => 'Durasi film wajib diisi.',
            'duration_minutes.integer' => 'Durasi harus berupa angka (menit).',
            'duration_minutes.min' => 'Durasi minimal 10 menit.',
            
            'poster_url.url' => 'URL poster harus valid.',
            'poster_url.max' => 'URL poster maksimal 1000 karakter.',
            
            'category_ids.required' => 'Film harus memiliki minimal satu kategori.',
            'category_ids.array' => 'Kategori harus berupa daftar.',
            'category_ids.min' => 'Pilih minimal satu kategori.',
            'category_ids.*.exists' => 'Beberapa kategori tidak valid.',
        ];
    }
}
