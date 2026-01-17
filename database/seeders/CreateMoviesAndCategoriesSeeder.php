<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;
use App\Models\Movie;

class CreateMoviesAndCategoriesSeeder extends Seeder
{
    public function run(): void
    {
        // === 1. Kategori yang Tersedia (akan dibuat jika belum ada) ===
        $categoriesList = [
            'Action' => 'Film penuh aksi, pertarungan, dan petualangan',
            'Adventure' => 'Petualangan seru dan menegangkan',
            'Thriller' => 'Ketegangan dan misteri yang mendebarkan',
            'Romance' => 'Kisah cinta dan hubungan emosional',
            'Horror' => 'Film yang menakutkan dan mencekam',
            'Animation' => 'Film animasi untuk segala usia',
        ];

        $categoryIds = [];
        foreach ($categoriesList as $name => $desc) {
            $category = Category::firstOrCreate(
                ['category_name' => $name],
                ['description' => $desc]
            );
            $categoryIds[$name] = $category->id;
        }

        // === 2. Data Film Baru (Sesuai dengan JSON kamu + 2 film tambahan) ===
        $movies = [
            [
                'title' => 'Transformer',
                'title_img' => 'https://distreaming.my.id/assets/images/movies/transformer-title.png',
                'bg_img' => 'https://distreaming.my.id/assets/images/movies/bg-transformer.jpg',
                'preview_img' => 'https://distreaming.my.id/assets/images/movies/transformer.jpg',
                'trailer_url' => 'https://www.youtube.com/embed/TxPNrwbuxN0',
                'release_year' => 2023,
                'release_date' => '2023-09-18',
                'age_limit' => '15+',
                'duration_minutes' => 127,
                'type' => 'coming',
                'is_active' => true,
                'description' => 'Film aksi petualangan yang mengikuti pertempuran epik antara Autobots dan Decepticons di bumi. Ketika ancaman besar mengancam umat manusia, aliansi antara manusia dan robot menjadi satu-satunya harapan. Pertarungan spektakuler, teknologi canggih, dan pengorbanan menjadi inti cerita.',
                'categories' => ['Adventure'],
            ],
            [
                'title' => 'Meg 2',
                'title_img' => 'https://distreaming.my.id/assets/images/movies/meg-2-title.png',
                'bg_img' => 'https://distreaming.my.id/assets/images/movies/bg-meg-2.jpeg',
                'preview_img' => 'https://distreaming.my.id/assets/images/movies/meg-2.jpg',
                'trailer_url' => 'https://www.youtube.com/embed/dG91B3hHyY4',
                'release_year' => 2023,
                'release_date' => '2023-08-04',
                'age_limit' => '16+',
                'duration_minutes' => 116,
                'type' => 'coming',
                'is_active' => false,
                'description' => 'Sequel dari film Meg yang menampilkan teror hiu purba raksasa dari kedalaman laut. Sebuah misi penelitian berubah menjadi mimpi buruk ketika makhluk mematikan tersebut lepas kendali. Ketegangan, aksi bawah laut, dan perjuangan bertahan hidup mendominasi film ini.',
                'categories' => ['Thriller'],
            ],
            [
                'title' => 'Fast X',
                'title_img' => 'https://distreaming.my.id/assets/images/movies/fast-x-title.png',
                'bg_img' => 'https://distreaming.my.id/assets/images/movies/bg-fast-x.jpeg',
                'preview_img' => 'https://distreaming.my.id/assets/images/movies/fast-x.jpeg',
                'trailer_url' => 'https://www.youtube.com/embed/32RAq6JzY-w',
                'release_year' => 2023,
                'release_date' => '2023-10-04',
                'age_limit' => '12+',
                'duration_minutes' => 141,
                'type' => 'coming',
                'is_active' => false,
                'description' => 'Keluarga Dom Toretto kembali menghadapi musuh paling berbahaya yang pernah ada. Masa lalu kelam kembali menghantui, memaksa mereka mempertaruhkan segalanya demi melindungi orang-orang yang mereka cintai. Aksi balapan ekstrem dan ledakan spektakuler menjadi ciri khas film ini.',
                'categories' => ['Action'],
            ],
            [
                'title' => 'Jailer',
                'title_img' => 'https://distreaming.my.id/assets/images/movies/jailer-title.png',
                'bg_img' => 'https://distreaming.my.id/assets/images/movies/bg-jailer.jpeg',
                'preview_img' => 'https://distreaming.my.id/assets/images/movies/jailer.jpg',
                'trailer_url' => 'https://www.youtube.com/embed/lshAqOT7BB8',
                'release_year' => 2023,
                'release_date' => '2023-11-09',
                'age_limit' => '15+',
                'duration_minutes' => 168,
                'type' => 'coming',
                'is_active' => false,
                'description' => 'Seorang mantan sipir penjara harus kembali ke dunia kriminal untuk membalas kematian orang yang ia cintai. Dengan kecerdikan dan kekuatan mental, ia menghadapi jaringan kejahatan yang kejam. Film ini menyajikan aksi brutal, emosi mendalam, dan konflik moral yang kuat.',
                'categories' => ['Action'],
            ],
            [
                'title' => 'Beautiful Disaster',
                'title_img' => 'https://distreaming.my.id/assets/images/movies/beautiful-disaster-title.png',
                'bg_img' => 'https://distreaming.my.id/assets/images/movies/bg-beautiful-disaster.jpeg',
                'preview_img' => 'https://distreaming.my.id/assets/images/movies/beautiful-disaster.jpeg',
                'trailer_url' => 'https://www.youtube.com/embed/nvaenzyXl4o',
                'release_year' => 2023,
                'release_date' => '2023-11-12',
                'age_limit' => '12+',
                'duration_minutes' => 105,
                'type' => 'coming',
                'is_active' => false,
                'description' => 'Kisah cinta penuh konflik antara seorang mahasiswa berprestasi dan petarung jalanan yang bermasalah. Hubungan mereka diuji oleh masa lalu, emosi, dan keputusan impulsif. Film ini menyuguhkan drama romantis yang intens dengan dinamika hubungan yang kompleks.',
                'categories' => ['Romance'],
            ],
            [
                'title' => 'Ape vs. Mecha Ape',
                'title_img' => 'https://distreaming.my.id/assets/images/movies/ape-title.png',
                'bg_img' => 'https://distreaming.my.id/assets/images/movies/bg-ape.jpeg',
                'preview_img' => 'https://distreaming.my.id/assets/images/movies/ape.jpg',
                'trailer_url' => 'https://www.youtube.com/embed/dtyPh5yCoWg',
                'release_year' => 2023,
                'release_date' => '2023-12-30',
                'age_limit' => '14+',
                'duration_minutes' => 165,
                'type' => 'coming',
                'is_active' => false,
                'description' => 'Pertempuran dahsyat terjadi ketika seekor primata raksasa harus melawan versi mekanisnya yang diciptakan manusia. Kota menjadi medan perang antara kekuatan alam dan teknologi. Film ini menampilkan aksi monster epik dengan ketegangan dan kehancuran besar.',
                'categories' => ['Thriller'],
            ],
            [
                'title' => 'Assassin',
                'title_img' => 'https://distreaming.my.id/assets/images/movies/assassin-title.png',
                'bg_img' => 'https://distreaming.my.id/assets/images/movies/bg-assassin.jpg',
                'preview_img' => 'https://distreaming.my.id/assets/images/movies/assassin.jpg',
                'trailer_url' => 'https://www.youtube.com/embed/qiUATuIhUw8',
                'release_year' => 2023,
                'release_date' => '2023-09-17',
                'age_limit' => '16+',
                'duration_minutes' => 88,
                'type' => 'coming',
                'is_active' => false,
                'description' => 'Seorang pembunuh bayaran profesional terjebak dalam konspirasi global yang mengancam nyawanya. Saat misi berubah menjadi perburuan, ia harus mengandalkan insting dan keahliannya untuk bertahan hidup. Thriller aksi ini dipenuhi kejutan dan konflik intens.',
                'categories' => ['Thriller'],
            ],
            [
                'title' => 'No Hard Feelings',
                'title_img' => 'https://distreaming.my.id/assets/images/movies/no-hard-feelings-title.png',
                'bg_img' => 'https://distreaming.my.id/assets/images/movies/bg-no-hard-feelings.jpeg',
                'preview_img' => 'https://distreaming.my.id/assets/images/movies/no-hard-feelings.jpeg',
                'trailer_url' => 'https://www.youtube.com/embed/7psP7xBEa28',
                'release_year' => 2023,
                'release_date' => '2023-10-06',
                'age_limit' => '14+',
                'duration_minutes' => 103,
                'type' => 'coming',
                'is_active' => false,
                'description' => 'Seorang wanita dewasa menerima tawaran tak biasa untuk mendekati seorang remaja introvert demi keuntungan finansial. Namun, hubungan yang awalnya palsu berubah menjadi ikatan emosional yang tulus. Film ini menyajikan komedi romantis dengan humor segar dan pesan kehidupan.',
                'categories' => ['Romance'],
            ],
            [
                'title' => 'Peter Pan & Wendy',
                'title_img' => 'https://distreaming.my.id/assets/images/movies/peter-pan-and-wendy-title.png',
                'bg_img' => 'https://distreaming.my.id/assets/images/movies/bg-peter-pan-and-wendy.jpeg',
                'preview_img' => 'https://distreaming.my.id/assets/images/movies/peter-pan-and-wendy.jpg',
                'trailer_url' => 'https://www.youtube.com/embed/9Ji5U2sTlLU',
                'release_year' => 2023,
                'release_date' => '2023-10-14',
                'age_limit' => '12+',
                'duration_minutes' => 109,
                'type' => 'coming',
                'is_active' => false,
                'description' => 'Wendy Darling memulai petualangan ajaib ke Neverland bersama Peter Pan. Mereka menghadapi bajak laut berbahaya dan menemukan makna keberanian serta kedewasaan. Film ini menghadirkan kisah klasik dengan sentuhan modern dan visual fantasi yang memukau.',
                'categories' => ['Adventure'],
            ],
            [
                'title' => 'Heart of Stone',
                'title_img' => 'https://distreaming.my.id/assets/images/movies/heart-of-stone-title.png',
                'bg_img' => 'https://distreaming.my.id/assets/images/movies/bg-heart-of-stone.jpeg',
                'preview_img' => 'https://distreaming.my.id/assets/images/movies/heart-of-stone.jpg',
                'trailer_url' => 'https://www.youtube.com/embed/XuDwndGaCFo',
                'release_year' => 2023,
                'release_date' => '2023-11-25',
                'age_limit' => '14+',
                'duration_minutes' => 122,
                'type' => 'coming',
                'is_active' => false,
                'description' => 'Seorang agen rahasia wanita terjebak dalam misi berbahaya yang melibatkan teknologi mematikan. Ketika kepercayaan diuji, ia harus memilih antara tugas dan keselamatan dunia. Film ini menyajikan aksi cepat, intrik mata-mata, dan ketegangan tanpa henti.',
                'categories' => ['Adventure'],
            ],
            [
                'title' => 'The Little Mermaid',
                'title_img' => 'https://distreaming.my.id/assets/images/movies/the-little-mermaid-title.png',
                'bg_img' => 'https://distreaming.my.id/assets/images/movies/bg-little-mermaid.jpg',
                'preview_img' => 'https://distreaming.my.id/assets/images/movies/the-little-mermaid.jpeg',
                'trailer_url' => 'https://www.youtube.com/embed/kpGo2_d3oYE',
                'release_year' => 2023,
                'release_date' => '2023-09-27',
                'age_limit' => '12+',
                'duration_minutes' => 134,
                'type' => 'schedule',
                'is_active' => false,
                'description' => 'Seorang putri duyung muda bermimpi menjelajahi dunia manusia. Demi cinta dan kebebasan, ia membuat perjanjian berbahaya yang mengancam dunianya. Versi live-action ini menghadirkan kisah klasik dengan visual indah dan emosi yang lebih mendalam.',
                'categories' => ['Romance'],
            ],
            [
                'title' => 'Sixty Five',
                'title_img' => 'https://distreaming.my.id/assets/images/movies/the-65-title.png',
                'bg_img' => 'https://distreaming.my.id/assets/images/movies/bg-65.jpeg',
                'preview_img' => 'https://distreaming.my.id/assets/images/movies/65.jpg',
                'trailer_url' => 'https://www.youtube.com/embed/bHXejJq5vr0',
                'release_year' => 2023,
                'release_date' => '2023-10-27',
                'age_limit' => '15+',
                'duration_minutes' => 93,
                'type' => 'schedule',
                'is_active' => false,
                'description' => 'Setelah kecelakaan pesawat luar angkasa, seorang astronot terdampar di bumi purba yang dipenuhi makhluk berbahaya. Ia harus melindungi satu-satunya penyintas dan mencari jalan pulang. Film ini menggabungkan fiksi ilmiah dengan ketegangan survival.',
                'categories' => ['Action'],
            ],
            [
                'title' => 'The Black Demon',
                'title_img' => 'https://distreaming.my.id/assets/images/movies/the-black-demon-title.png',
                'bg_img' => 'https://distreaming.my.id/assets/images/movies/bg-the-black-demon.jpeg',
                'preview_img' => 'https://distreaming.my.id/assets/images/movies/the-black-demon.jpg',
                'trailer_url' => 'https://www.youtube.com/embed/z1xJAyVKAPY',
                'release_year' => 2023,
                'release_date' => '2023-10-21',
                'age_limit' => '16+',
                'duration_minutes' => 100,
                'type' => 'schedule',
                'is_active' => false,
                'description' => 'Sebuah keluarga yang sedang berlibur menghadapi teror hiu raksasa legendaris di perairan terpencil. Ketika bantuan tak kunjung datang, mereka harus berjuang melawan ketakutan dan alam liar. Film ini menawarkan horor laut yang menegangkan dan mencekam.',
                'categories' => ['Thriller'],
            ],
            [
                'title' => 'The Tank',
                'title_img' => 'https://distreaming.my.id/assets/images/movies/the-tank-title.png',
                'bg_img' => 'https://distreaming.my.id/assets/images/movies/bg-the-tank.jpeg',
                'preview_img' => 'https://distreaming.my.id/assets/images/movies/the-tank.jpeg',
                'trailer_url' => 'https://www.youtube.com/embed/23GmhsmrCIo',
                'release_year' => 2023,
                'release_date' => '2023-11-03',
                'age_limit' => '17+',
                'duration_minutes' => 100,
                'type' => 'schedule',
                'is_active' => false,
                'description' => 'Sepasang suami istri menemukan rahasia gelap di properti baru mereka. Sebuah makhluk mengerikan bersembunyi dan mulai meneror kehidupan mereka. Film horor ini menghadirkan suasana suram, ketegangan psikologis, dan teror yang perlahan meningkat.',
                'categories' => ['Horror'],
            ],
            [
                'title' => 'The Covenant',
                'title_img' => 'https://distreaming.my.id/assets/images/movies/the-covenant-title.png',
                'bg_img' => 'https://distreaming.my.id/assets/images/movies/bg-the-covenant.jpeg',
                'preview_img' => 'https://distreaming.my.id/assets/images/movies/the-covenant.jpg',
                'trailer_url' => 'https://www.youtube.com/embed/02PPMPArNEQ',
                'release_year' => 2023,
                'release_date' => '2023-12-16',
                'age_limit' => '12+',
                'duration_minutes' => 123,
                'type' => 'schedule',
                'is_active' => false,
                'description' => 'Seorang tentara Amerika membentuk ikatan kuat dengan penerjemah lokal selama misi berbahaya. Ketika janji perlindungan diuji, ia harus mempertaruhkan segalanya demi menyelamatkan sahabatnya. Film ini menyoroti loyalitas, pengorbanan, dan realitas perang.',
                'categories' => ['Action'],
            ],
            [
                'title' => 'Zootopia 2',
                'title_img' => 'https://distreaming.my.id/assets/images/movies/zootopia-2-title.png',
                'bg_img' => 'https://distreaming.my.id/assets/images/movies/bg-zootopia-2.jpeg',
                'preview_img' => 'https://distreaming.my.id/assets/images/movies/zootopia-2.jpg',
                'trailer_url' => 'https://www.youtube.com/embed/...',
                'release_year' => 2025,
                'release_date' => '2025-01-10',
                'age_limit' => 'All',
                'duration_minutes' => 105,
                'type' => 'coming',
                'is_active' => true,
                'description' => 'Judy Hopps dan Nick Wilde kembali menyelidiki kasus besar yang mengancam keseimbangan kota Zootopia. Dengan tantangan baru dan karakter misterius, mereka belajar tentang kepercayaan dan kerja sama. Film animasi ini penuh humor, petualangan, dan pesan sosial.',
                'categories' => ['Animation'],
            ],
            [
                'title' => 'Avatar: Fire and Ash',
                'title_img' => 'https://distreaming.my.id/assets/images/movies/Avatar-title.png',
                'bg_img' => 'https://distreaming.my.id/assets/images/movies/bg-avatar.jpeg',
                'preview_img' => 'https://distreaming.my.id/assets/images/movies/Avatar.jpg',
                'trailer_url' => 'https://www.youtube.com/embed/...',
                'release_year' => 2025,
                'release_date' => '2025-01-15',
                'age_limit' => '13+',
                'duration_minutes' => 190,
                'type' => 'coming',
                'is_active' => true,
                'description' => 'Konflik baru muncul di Pandora ketika klan api yang agresif bangkit melawan keseimbangan alam. Jake Sully dan keluarganya harus menghadapi ancaman yang lebih brutal. Film ini menampilkan visual epik, konflik emosional, dan eksplorasi budaya baru di Pandora.',
                'categories' => ['Action', 'Sci-Fi'],
            ],
        ];

        // === 3. Simpan Film & Relasi Kategori ===
        foreach ($movies as $movieData) {
            $movie = Movie::create([
                'title' => $movieData['title'],
                'title_img' => $movieData['title_img'],
                'bg_img' => $movieData['bg_img'],
                'preview_img' => $movieData['preview_img'],
                'trailer_url' => $movieData['trailer_url'],
                'release_year' => $movieData['release_year'],
                'release_date' => $movieData['release_date'],
                'age_limit' => $movieData['age_limit'],
                'duration_minutes' => $movieData['duration_minutes'],
                'type' => $movieData['type'],
                'is_active' => $movieData['is_active'],
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

        $this->command->info('✅ Kategori dan 17 film berhasil dibuat!');
    }
}
