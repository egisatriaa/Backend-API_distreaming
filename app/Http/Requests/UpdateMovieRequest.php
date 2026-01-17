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
            'title_img' => 'nullable|url|max:1000',
            'bg_img' => 'nullable|url|max:1000',
            'preview_img' => 'nullable|url|max:1000',
            'trailer_url' => 'nullable|url|max:1000',
            'age_limit' => 'nullable|string|max:10',
            'release_date' => 'nullable|date',
            'type' => 'nullable|in:coming,now_playing',
            'is_active' => 'nullable|boolean',
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

            'title_img.url' => 'URL gambar judul harus valid.',
            'title_img.max' => 'URL gambar judul maksimal 1000 karakter.',

            'bg_img.url' => 'URL background harus valid.',
            'bg_img.max' => 'URL background maksimal 1000 karakter.',

            'preview_img.url' => 'URL preview harus valid.',
            'preview_img.max' => 'URL preview maksimal 1000 karakter.',

            'trailer_url.url' => 'URL trailer harus valid.',
            'trailer_url.max' => 'URL trailer maksimal 1000 karakter.',

            'age_limit.max' => 'Batas usia maksimal 10 karakter.',

            'release_date.date' => 'Tanggal rilis harus dalam format tanggal.',

            'type.in' => 'Tipe film harus salah satu dari: coming, now_playing.',

            'is_active.boolean' => 'Status aktif harus berupa true atau false.',

            'category_ids.required' => 'Jika mengupdate kategori, minimal pilih satu.',
            'category_ids.array' => 'Kategori harus berupa daftar.',
            'category_ids.min' => 'Pilih minimal satu kategori.',
            'category_ids.*.exists' => 'Beberapa kategori tidak valid.',
        ];
    }
}