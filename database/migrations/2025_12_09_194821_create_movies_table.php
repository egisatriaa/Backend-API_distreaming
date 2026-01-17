<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('movies', function (Blueprint $table) {
            $table->id();
            $table->string('title', 255);
            $table->text('description')->nullable();
            $table->integer('duration_minutes');
            $table->integer('release_year');
            $table->text('poster_url')->nullable();

            // === Kolom Baru untuk V2 ===
            $table->string('title_img')->nullable();
            $table->string('bg_img')->nullable();
            $table->string('preview_img')->nullable();
            $table->string('trailer_url')->nullable();
            $table->string('age_limit', 10)->nullable();
            $table->date('release_date')->nullable();
            $table->enum('type', ['coming', 'now_playing', 'schedule'])->default('now_playing'); // <= Diupdate
            $table->boolean('is_active')->default(true);

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('movies');
    }
};