<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Movie;
use App\Models\Category;
use App\Models\Rating;
use App\Models\WatchHistory;

class FullApiTest extends TestCase
{
    use RefreshDatabase;

    private string $adminToken;
    private string $userToken;
    private int $adminId;
    private int $userId;
    private int $movieId;
    private int $categoryId;

    protected function setUp(): void
    {
        parent::setUp();

        // Jalankan seeder
        $this->seed();

        // Ambil user dari DB
        $admin = User::where('email', 'admin@example.com')->first();
        $user = User::where('email', 'user@example.com')->first();

        $this->adminId = $admin->id;
        $this->userId = $user->id;

        // Login & simpan token
        $adminLogin = $this->postJson('/api/login', [
            'email' => 'admin@example.com',
            'password' => 'admin123',
        ]);
        $this->adminToken = $adminLogin->json('token');

        $userLogin = $this->postJson('/api/login', [
            'email' => 'user@example.com',
            'password' => 'user123',
        ]);
        $this->userToken = $userLogin->json('token');

        // Ambil movie & category pertama
        $this->movieId = Movie::first()->id;
        $this->categoryId = Category::first()->id;
    }

    // =============== AUTH TESTS ===============
    public function test_register_success(): void
    {
        $response = $this->postJson('/api/register', [
            'username' => 'newuser',
            'email' => 'newuser@example.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ]);

        $response->assertStatus(201)
            ->assertJsonStructure(['message', 'data']);
    }

    public function test_login_success(): void
    {
        $response = $this->postJson('/api/login', [
            'email' => 'user@example.com',
            'password' => 'user123',
        ]);

        $response->assertStatus(200)
            ->assertJsonStructure(['message', 'user', 'token']);
    }

    public function test_login_invalid_credentials(): void
    {
        $response = $this->postJson('/api/login', [
            'email' => 'user@example.com',
            'password' => 'wrongpass',
        ]);

        $response->assertStatus(401);
    }

    // =============== PUBLIC MOVIE TESTS ===============
    public function test_list_movies(): void
    {
        $response = $this->getJson('/api/movies');

        $response->assertStatus(200)
            ->assertJson(['message' => 'Movies berhasil ditampilkan.'])
            ->assertJsonStructure(['data']);
    }

    public function test_search_movies(): void
    {
        $response = $this->getJson('/api/movies?search=Oppenheimer');

        $response->assertStatus(200);
        // Tidak assert isi karena tergantung seeder
    }

    public function test_filter_by_category(): void
    {
        $response = $this->getJson("/api/movies?category_id={$this->categoryId}");

        $response->assertStatus(200);
    }

    public function test_get_movie_detail(): void
    {
        $response = $this->getJson("/api/movies/{$this->movieId}");

        $response->assertStatus(200)
            ->assertJsonStructure([
                'message',
                'data' => ['id', 'title', 'rating_avg', 'rating_class', 'categories']
            ]);
    }

    // =============== USER-ONLY TESTS ===============
    public function test_user_can_rate_movie(): void
    {
        $response = $this->withHeader('Authorization', "Bearer {$this->userToken}")
            ->postJson("/api/movies/{$this->movieId}/rate", [
                'score' => 8.5,
                'review_text' => 'Great movie!',
            ]);

        $response->assertStatus(201)
            ->assertJsonStructure(['message', 'data']);

        $this->assertDatabaseHas('ratings', [
            'user_id' => $this->userId,
            'movie_id' => $this->movieId,
            'score' => '8.5'
        ]);
    }

    public function test_user_cannot_rate_same_movie_twice(): void
    {
        // Rate pertama
        $this->withHeader('Authorization', "Bearer {$this->userToken}")
            ->postJson("/api/movies/{$this->movieId}/rate", [
                'score' => 7.0,
                'review_text' => 'First rating',
            ]);

        // Rate kedua → harus error
        $response = $this->withHeader('Authorization', "Bearer {$this->userToken}")
            ->postJson("/api/movies/{$this->movieId}/rate", [
                'score' => 9.0,
                'review_text' => 'Second rating',
            ]);

        $response->assertStatus(409);
    }

    public function test_user_can_watch_movie(): void
    {
        $response = $this->withHeader('Authorization', "Bearer {$this->userToken}")
            ->postJson("/api/movies/{$this->movieId}/watch", [
                'is_completed' => true,
            ]);

        $response->assertStatus(201)
            ->assertJsonStructure(['message', 'data']);

        $this->assertDatabaseHas('watch_histories', [
            'user_id' => $this->userId,
            'movie_id' => $this->movieId,
            'is_completed' => 1,
        ]);
    }

    public function test_get_watch_history(): void
    {
        // Pastikan ada data
        WatchHistory::create([
            'user_id' => $this->userId,
            'movie_id' => $this->movieId,
            'is_completed' => false,
        ]);

        $response = $this->withHeader('Authorization', "Bearer {$this->userToken}")
            ->getJson('/api/watch-history');

        $response->assertStatus(200)
            ->assertJsonStructure([
                'message',
                'data' => [
                    '*' => ['id', 'movie', 'is_completed']
                ]
            ]);
    }

    // =============== ADMIN-ONLY TESTS ===============
    public function test_admin_can_create_movie(): void
    {
        // Pastikan data ada
        $this->assertNotNull($this->categoryId, 'Category ID is null');
        $this->assertGreaterThan(0, Category::count(), 'No categories');

        $response = $this->withHeader('Authorization', "Bearer {$this->adminToken}")
            ->postJson('/api/admin/movies', [
                'title' => 'Test Movie',
                'release_year' => 2023,
                'duration_minutes' => 100,
                'category_ids' => [$this->categoryId],
            ]);

        // Debug jika gagal
        if ($response->getStatusCode() !== 201) {
            $response->dump(); // ← ini akan tampilkan error validasi
        }

        $response->assertStatus(201)
            ->assertJsonStructure(['message', 'data']);
    }

    public function test_user_cannot_access_admin_routes(): void
    {
        $response = $this->withHeader('Authorization', "Bearer {$this->userToken}")
            ->getJson('/api/admin/movies');

        $response->assertStatus(403); // Forbidden
    }

    public function test_unauthenticated_cannot_access_user_routes(): void
    {
        $response = $this->postJson("/api/movies/{$this->movieId}/rate", [
            'score' => 5.0,
        ]);

        $response->assertStatus(401); // Unauthorized
    }

    public function test_soft_deleted_movie_not_in_public_api(): void
    {
        $movie = Movie::first();
        $movie->delete(); // soft delete

        $response = $this->getJson("/api/movies/{$movie->id}");

        $response->assertStatus(404);
    }
}
