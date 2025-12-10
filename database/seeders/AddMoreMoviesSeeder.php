<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;
use App\Models\Movie;

class AddMoreMoviesSeeder extends Seeder
{
    public function run(): void
    {
        // === 1. Ambil semua kategori yang sudah ada ===
        $existingCategories = Category::pluck('id', 'category_name')->toArray();

        // === 2. Tambahkan kategori baru jika belum ada ===
        $newCategoryNames = ['Comedy', 'Romance', 'Documentary', 'Crime'];
        foreach ($newCategoryNames as $name) {
            if (!isset($existingCategories[$name])) {
                $desc = match ($name) {
                    'Comedy' => 'Film yang menghadirkan kelucuan dan tawa',
                    'Romance' => 'Kisah cinta dan hubungan emosional',
                    'Documentary' => 'Film non-fiksi berbasis fakta dan realitas',
                    'Crime' => 'Kisah kejahatan, detektif, dan penegakan hukum',
                    default => 'Kategori film',
                };
                $category = Category::create([
                    'category_name' => $name,
                    'description' => $desc,
                ]);
                $existingCategories[$name] = $category->id;
            }
        }

        // === 3. Data 15 Film Baru ===
        $newMovies = [
            [
                'title' => 'Oppenheimer',
                'release_year' => 2023,
                'duration_minutes' => 180,
                'poster_url' => 'https://image.tmdb.org/t/p/w1280/1E5baAaEse26fej7uHcjOgEE2t2.jpg',
                'description' => 'Kisah ilmuwan J. Robert Oppenheimer dalam pengembangan bom atom.',
                'categories' => ['Drama', 'History'],
            ],
            [
                'title' => 'Spider-Man: Across the Spider-Verse',
                'release_year' => 2023,
                'duration_minutes' => 140,
                'poster_url' => 'https://image.tmdb.org/t/p/w1280/8Vt6mWEReuy4Of61Lnj5Xj704m8.jpg',
                'description' => 'Miles Morales melintasi multiverse Spider-Man yang tak terbatas.',
                'categories' => ['Animation', 'Action', 'Sci-Fi'],
            ],
            [
                'title' => 'Poor Things',
                'release_year' => 2023,
                'duration_minutes' => 141,
                'poster_url' => 'https://image.tmdb.org/t/p/w1280/kCGlIMHnOm8JPXq3rXM6c5wMxcT.jpg',
                'description' => 'Seorang wanita muda dibangkitkan dan memulai petualangan eksplorasi diri.',
                'categories' => ['Drama', 'Comedy', 'Sci-Fi'],
            ],
            [
                'title' => 'The Holdovers',
                'release_year' => 2023,
                'duration_minutes' => 133,
                'poster_url' => 'https://image.tmdb.org/t/p/w1280/ylXrhRxZgs80gIBlfS97Xu73uCa.jpg',
                'description' => 'Guru dan murid terjebak di asrama sekolah selama liburan Natal.',
                'categories' => ['Drama', 'Comedy'],
            ],
            [
                'title' => '12th Fail',
                'release_year' => 2023,
                'duration_minutes' => 160,
                'poster_url' => 'https://image.tmdb.org/t/p/w1280/cDWW5l4NTWtQi9McwevrY3knsTd.jpg',
                'description' => 'Kisah nyata perjuangan seorang pria miskin menjadi pegawai negeri.',
                'categories' => ['Drama'],
            ],
            [
                'title' => 'Everything Everywhere All at Once',
                'release_year' => 2022,
                'duration_minutes' => 139,
                'poster_url' => 'https://image.tmdb.org/t/p/w1280/u68AjlvlutfEIcpmbYpKcdi09ut.jpg',
                'description' => 'Ibu rumah tangga biasa menyelamatkan multiverse dari kehancuran.',
                'categories' => ['Action', 'Comedy', 'Sci-Fi'],
            ],
            [
                'title' => 'The Boy, the Mole, the Fox and the Horse',
                'release_year' => 2022,
                'duration_minutes' => 33,
                'poster_url' => 'https://image.tmdb.org/t/p/w1280/wAKBWRhMmBtrCCuqmFwPm2RGTph.jpg',
                'description' => 'Animasi pendek tentang persahabatan dan makna hidup.',
                'categories' => ['Animation', 'Drama'],
            ],
            [
                'title' => 'The Elephant Whisperers',
                'release_year' => 2022,
                'duration_minutes' => 41,
                'poster_url' => 'https://image.tmdb.org/t/p/w1280/nIdpE38yLKOnujLWi6R58y7zxu0.jpg',
                'description' => 'Dokumenter tentang pasangan yang merawat bayi gajah yatim.',
                'categories' => ['Documentary'],
            ],
            [
                'title' => 'The Story of PuPu',
                'release_year' => 1998,
                'duration_minutes' => 92,
                'poster_url' => 'https://image.tmdb.org/t/p/w1280/t21fkasr2HSqdBXZBmuN1gBrmPj.jpg',
                'description' => 'Drama Jepang tentang persahabatan dan ambisi di masa muda.',
                'categories' => ['Drama'],
            ],
            [
                'title' => 'Barfi!',
                'release_year' => 2012,
                'duration_minutes' => 150,
                'poster_url' => 'https://image.tmdb.org/t/p/w1280/8lVuWmArvr41CvyvpgI3elD5iB1.jpg',
                'description' => 'Kisah cinta tuli-pbisu dengan latar India tahun 1970-an.',
                'categories' => ['Drama', 'Romance'],
            ],
            [
                'title' => 'Inception',
                'release_year' => 2010,
                'duration_minutes' => 148,
                'poster_url' => 'https://image.tmdb.org/t/p/w1280/qmDpIHrmpJINaRKAfWQfftjCdyi.jpg',
                'description' => 'Tim pencuri yang mencuri rahasia melalui alam bawah sadar.',
                'categories' => ['Action', 'Sci-Fi', 'Thriller'],
            ],
            [
                'title' => 'Interstellar',
                'release_year' => 2014,
                'duration_minutes' => 169,
                'poster_url' => 'https://image.tmdb.org/t/p/w1280/rAiYTfKGqDCRIIqo664sY9XZIvQ.jpg',
                'description' => 'Petualangan luar angkasa untuk menyelamatkan umat manusia.',
                'categories' => ['Sci-Fi', 'Drama'],
            ],
            [
                'title' => 'The Dark Knight',
                'release_year' => 2008,
                'duration_minutes' => 152,
                'poster_url' => 'https://image.tmdb.org/t/p/w1280/qJ2tW6WMUDux911r6m7haRef0WH.jpg',
                'description' => 'Batman menghadapi ancaman terbesarnya: The Joker.',
                'categories' => ['Action', 'Crime', 'Drama'],
            ],
            [
                'title' => 'Parasite',
                'release_year' => 2019,
                'duration_minutes' => 132,
                'poster_url' => 'https://image.tmdb.org/t/p/w1280/7IiTTgloJzvGI1TAYymCfbfl3vT.jpg',
                'description' => 'Keluarga miskin menyusup ke kehidupan keluarga kaya.',
                'categories' => ['Drama', 'Thriller', 'Comedy'],
            ],
            [
                'title' => 'Joker (2019)',
                'release_year' => 2019,
                'duration_minutes' => 122,
                'poster_url' => 'https://image.tmdb.org/t/p/w1280/udDclJoHjfjb8Ekgsd4FDteOkCU.jpg',
                'description' => 'Asal-usul Arthur Fleck menjadi Joker di kota Gotham.',
                'categories' => ['Drama', 'Crime', 'Thriller'],
            ],
        ];

        // Tambahkan kategori "History" jika diperlukan
        if (!isset($existingCategories['History'])) {
            $history = Category::create([
                'category_name' => 'History',
                'description' => 'Film berlatar peristiwa sejarah nyata',
            ]);
            $existingCategories['History'] = $history->id;
        }

        // === 4. Simpan Film Baru ===
        foreach ($newMovies as $movieData) {
            $movie = Movie::create([
                'title' => $movieData['title'],
                'release_year' => $movieData['release_year'],
                'duration_minutes' => $movieData['duration_minutes'],
                'poster_url' => $movieData['poster_url'],
                'description' => $movieData['description'],
            ]);

            $assignedCategoryIds = [];
            foreach ($movieData['categories'] as $catName) {
                if (isset($existingCategories[$catName])) {
                    $assignedCategoryIds[] = $existingCategories[$catName];
                }
            }

            if (!empty($assignedCategoryIds)) {
                $movie->categories()->attach($assignedCategoryIds);
            }
        }

        $this->command->info('✅ 15 film tambahan berhasil dibuat!');
    }
}
