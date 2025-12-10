<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;
use App\Models\Movie;

class CreateMoviesAndCategoriesSeeder extends Seeder
{
    public function run(): void
    {
        // === 1. Buat Kategori Dasar ===
        $categories = [
            'Action' => 'Film penuh aksi, pertarungan, dan petualangan',
            'Drama' => 'Kisah emosional dan realistis kehidupan',
            'Horror' => 'Film yang menakutkan dan mencekam',
            'Sci-Fi' => 'Fiksi ilmiah dengan teknologi masa depan',
            'Animation' => 'Film animasi untuk segala usia',
            'Thriller' => 'Ketegangan dan misteri yang mendebarkan',
        ];

        $categoryIds = [];
        foreach ($categories as $name => $desc) {
            $category = Category::create([
                'category_name' => $name,
                'description' => $desc,
            ]);
            $categoryIds[$name] = $category->id;
        }

        // === 2. Data Film dari TMDB ===
        $movies = [
            [
                'title' => 'Zootopia 2',
                'release_year' => 2025,
                'duration_minutes' => 105,
                'poster_url' => 'https://www.themoviedb.org/t/p/w1280/bjUWGw0Ao0qVWxagN3VCwBJHVo6.jpg',
                'description' => 'Kelanjutan petualangan Judy Hopps dan Nick Wilde di kota Zootopia.',
                'categories' => ['Animation'],
            ],
            [
                'title' => 'Avatar: Fire and Ash',
                'release_year' => 2025,
                'duration_minutes' => 190,
                'poster_url' => 'https://www.themoviedb.org/t/p/w1280/g96wHxU7EnoIFwemb2RgohIXrgW.jpg',
                'description' => 'Sambungan epik dari saga Avatar di planet Pandora.',
                'categories' => ['Sci-Fi', 'Action'],
            ],
            [
                'title' => 'Wicked: For Good',
                'release_year' => 2025,
                'duration_minutes' => 160,
                'poster_url' => 'https://www.themoviedb.org/t/p/w1280/jdd0Qv6V8AJ3V7Dr8aMIMUWxZ2c.jpg',
                'description' => 'Klimaks dari kisah persahabatan Elphaba dan Glinda.',
                'categories' => ['Drama', 'Musical'],
            ],
            [
                'title' => 'Frankenstein',
                'release_year' => 2025,
                'duration_minutes' => 130,
                'poster_url' => 'https://www.themoviedb.org/t/p/w1280/g4JtvGlQO7DByTI6frUobqvSL3R.jpg',
                'description' => 'Adaptasi modern dari klasik horor Mary Shelley.',
                'categories' => ['Horror', 'Drama'],
            ],
            [
                'title' => 'Wild Cat',
                'release_year' => 2024,
                'duration_minutes' => 110,
                'poster_url' => 'https://www.themoviedb.org/t/p/w1280/h893ImjM6Fsv5DFhKJdlZFZIJno.jpg',
                'description' => 'Kisah seorang jurnalis muda yang menyamar untuk menyelidiki perdagangan satwa liar.',
                'categories' => ['Thriller', 'Drama'],
            ],
            [
                'title' => 'Resident Evil: Death Island',
                'release_year' => 2023,
                'duration_minutes' => 94,
                'poster_url' => 'https://www.themoviedb.org/t/p/w1280/qayga07ICNDswm0cMJ8P3VwklFZ.jpg',
                'description' => 'Leon, Chris, dan Jill bersatu melawan ancaman virus di San Francisco.',
                'categories' => ['Action', 'Horror', 'Sci-Fi'],
            ],
            [
                'title' => 'Resident Evil: Vendetta',
                'release_year' => 2017,
                'duration_minutes' => 97,
                'poster_url' => 'https://www.themoviedb.org/t/p/w1280/kdiMtgjWXEH9QZ85hgmWaSwshjf.jpg',
                'description' => 'Chris Redfield dan Leon Kennedy melawan plot bioteror global.',
                'categories' => ['Action', 'Horror', 'Sci-Fi'],
            ],
            [
                'title' => 'Die Another Day',
                'release_year' => 2002,
                'duration_minutes' => 133,
                'poster_url' => 'https://www.themoviedb.org/t/p/w1280/bZmGqOhMhaLn8AoFMvFDct4tbrL.jpg',
                'description' => 'James Bond menyelidiki penyelundupan berlian dan konflik Korea.',
                'categories' => ['Action', 'Thriller'],
            ],
            [
                'title' => 'IT',
                'release_year' => 2017,
                'duration_minutes' => 135,
                'poster_url' => 'https://www.themoviedb.org/t/p/w1280/9E2y5Q7WlCVNEhP5GiVTjhEhx1o.jpg',
                'description' => 'Sebuah kota kecil diganggu oleh badut jahat yang memangsa ketakutan anak-anak.',
                'categories' => ['Horror', 'Thriller'],
            ],
            [
                'title' => '365 Days',
                'release_year' => 2020,
                'duration_minutes' => 117,
                'poster_url' => 'https://www.themoviedb.org/t/p/w1280/6KwrHucIE3CvNT7kTm2MAlZ4fYF.jpg',
                'description' => 'Seorang wanita diculik oleh bos mafia yang memberinya 365 hari untuk jatuh cinta.',
                'categories' => ['Drama', 'Thriller'],
            ],
        ];

        // Tambahkan kategori "Musical" jika belum ada
        if (!isset($categoryIds['Musical'])) {
            $musical = Category::create([
                'category_name' => 'Musical',
                'description' => 'Film dengan elemen nyanyian dan tarian',
            ]);
            $categoryIds['Musical'] = $musical->id;
        }

        // === 3. Simpan Film & Relasi Kategori ===
        foreach ($movies as $movieData) {
            $movie = Movie::create([
                'title' => $movieData['title'],
                'release_year' => $movieData['release_year'],
                'duration_minutes' => $movieData['duration_minutes'],
                'poster_url' => $movieData['poster_url'],
                'description' => $movieData['description'],
            ]);

            // Ambil ID kategori berdasarkan nama
            $assignedCategoryIds = [];
            foreach ($movieData['categories'] as $catName) {
                if (isset($categoryIds[$catName])) {
                    $assignedCategoryIds[] = $categoryIds[$catName];
                }
            }

            if (!empty($assignedCategoryIds)) {
                $movie->categories()->attach($assignedCategoryIds);
            }
        }

        $this->command->info('✅ 6 kategori & 10 film berhasil dibuat!');
    }
}