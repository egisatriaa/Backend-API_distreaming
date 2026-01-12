
---

# Dokumentasi API - Distreaming

## Base URL
```
https://distreaming.my.id/
```

## Daftar Isi
1. [Autentikasi](#autentikasi)
2. [Guest (Publik)](#guest-publik)
3. [User (Terotentikasi)](#user-terotentikasi)
4. [Admin (Terotentikasi & Admin)](#admin-terotentikasi--admin)

---

## Autentikasi

### Register
- **URL:** `POST /api/register`
- **Deskripsi:** Mendaftarkan user baru.
- **Body:**
  ```json
  {
    "username": "string",
    "email": "string",
    "password": "string"
  }
  ```
- **Response:**
  ```json
  {
    "message": "Register success.",
    "data": {
      "id": 1,
      "username": "user",
      "email": "user@example.com",
      "role": "user"
    }
  }
  ```

### Login
- **URL:** `POST /api/login`
- **Deskripsi:** Login user dan menghasilkan token.
- **Body:**
  ```json
  {
    "email": "string",
    "password": "string"
  }
  ```
- **Response:**
  ```json
  {
    "message": "Login success.",
    "data": {
      "user": {
        "id": 1,
        "username": "user",
        "email": "user@example.com",
        "role": "user"
      },
      "token": "sanctum-token-string"
    }
  }
  ```

### Logout
- **URL:** `POST /api/user/logout`
- **Header:** `Authorization: Bearer <token>`
- **Deskripsi:** Logout user dan menghapus token.
- **Response:**
  ```json
  {
    "message": "Logout success.",
    "data": null
  }
  ```

---

## Guest (Publik)

### Daftar Film
- **URL:** `GET /api/guest/movies`
- **Deskripsi:** Mendapatkan daftar film.
- **Parameter Query:**
  - `search` (opsional): Mencari film berdasarkan judul.
  - `category_id` (opsional): Filter film berdasarkan Category.
  - `per_page` (opsional): Jumlah data per halaman (default: 10, max: 100).
- **Response:**
  ```json
  {
    "message": "Movies fetched successfully.",
    "data": [...],
    "meta": {
      "current_page": 1,
      "last_page": 1,
      "per_page": 10,
      "total": 5
    }
  }
  ```

### Detail Film
- **URL:** `GET /api/guest/movies/{id}`
- **Deskripsi:** Mendapatkan detail film.
- **Response:**
  ```json
  {
    "message": "Movie detail fetched successfully.",
    "data": {
      "id": 1,
      "title": "Film A",
      "description": "...",
      "rating": { "avg": 8.5, "class": "Top Rated" },
      "categories": [...]
    }
  }
  ```

### Daftar Category
- **URL:** `GET /api/guest/categories`
- **Deskripsi:** Mendapatkan daftar Category.
- **Response:**
  ```json
  {
    "message": "Categories fetched successfully.",
    "data": [...]
  }
  ```

### Detail Category
- **URL:** `GET /api/guest/categories/{id}`
- **Deskripsi:** Mendapatkan detail Category dan film-film di dalamnya.
- **Response:**
  ```json
  {
    "message": "Category detail fetched.",
    "data": {
      "id": 1,
      "name": "Action",
      "movies": [...]
    }
  }
  ```

### Daftar Rating untuk Film
- **URL:** `GET /api/guest/movies/{movie}/ratings`
- **Deskripsi:** Mendapatkan daftar rating untuk film.
- **Parameter Query:**
  - `per_page` (opsional): Jumlah data per halaman (default: 10, max: 50).
- **Response:**
  ```json
  {
    "message": "Daftar rating berhasil ditampilkan.",
    "data": [...]
  }
  ```

---

## User (Terotentikasi)

### Profil Saya
- **URL:** `GET /api/user/me`
- **Header:** `Authorization: Bearer <token>`
- **Deskripsi:** Mendapatkan profil user yang sedang login.
- **Response:**
  ```json
  {
    "id": 1,
    "username": "user",
    "email": "user@example.com",
    "role": "user"
  }
  ```

### Memberi Rating ke Film
- **URL:** `POST /api/user/movies/{movie}/rate`
- **Header:** `Authorization: Bearer <token>`
- **Deskripsi:** Memberi rating dan ulasan ke film.
- **Body:**
  ```json
  {
    "score": 9.5,
    "review_text": "Bagus banget!"
  }
  ```
- **Response:**
  ```json
  {
    "message": "Rating berhasil ditambahkan.",
    "data": { ... }
  }
  ```

### Riwayat Tontonan
- **URL:** `GET /api/user/watch-history`
- **Header:** `Authorization: Bearer <token>`
- **Deskripsi:** Mendapatkan riwayat tontonan user.
- **Parameter Query:**
  - `per_page` (opsional): Jumlah data per halaman (default: 10, max: 50).
- **Response:**
  ```json
  {
    "message": "Riwayat tontonan berhasil ditampilkan.",
    "data": [...]
  }
  ```

### Simpan Riwayat Tontonan
- **URL:** `POST /api/user/movies/{movie}/watch-history`
- **Header:** `Authorization: Bearer <token>`
- **Deskripsi:** Menyimpan atau memperbarui riwayat tontonan.
- **Body:**
  ```json
  {
    "is_completed": true
  }
  ```
- **Response:**
  ```json
  {
    "message": "Riwayat tontonan berhasil disimpan.",
    "data": { ... }
  }
  ```

---

## Admin (Terotentikasi & Admin)

### Daftar Film (CRUD)
- **URL:** `GET /api/admin/movies`
- **Header:** `Authorization: Bearer <token>`, role: `admin`
- **Deskripsi:** Mendapatkan daftar film (termasuk yang soft deleted).
- **Parameter Query:**
  - `search`, `category_id`, `per_page` (seperti guest, tapi bisa lihat deleted).

### Detail Film
- **URL:** `GET /api/admin/movies/{id}`
- **Header:** `Authorization: Bearer <token>`, role: `admin`

### Tambah Film
- **URL:** `POST /api/admin/movies`
- **Header:** `Authorization: Bearer <token>`, role: `admin`
- **Body:**
  ```json
  {
    "title": "Judul Film",
    "description": "Deskripsi",
    "release_year": 2025,
    "duration_minutes": 120,
    "poster_url": "https://...",
    "category_ids": [1, 2]
  }
  ```

### Edit Film
- **URL:** `PUT /api/admin/movies/{id}`
- **Header:** `Authorization: Bearer <token>`, role: `admin`

### Hapus Film
- **URL:** `DELETE /api/admin/movies/{id}?force=true`
- **Header:** `Authorization: Bearer <token>`, role: `admin`
- **Deskripsi:** Soft delete (tanpa `force`), hard delete (dengan `force=true`).

---


### Admin - Category (CRUD)

#### 1. Daftar Category
- **URL:** `GET /api/admin/categories`
- **Header:** `Authorization: Bearer <token>`, role: `admin`
- **Deskripsi:** Mendapatkan daftar Category (termasuk yang soft deleted).
- **Parameter Query:**
  - `per_page` (opsional): Jumlah data per halaman (default: 10, max: 100).
- **Response:**
  ```json
  {
    "message": "Categories fetched successfully.",
    "data": [...],
    "meta": {
      "current_page": 1,
      "last_page": 1,
      "per_page": 10,
      "total": 5
    }
  }
  ```

#### 2. Detail Category
- **URL:** `GET /api/admin/categories/{id}`
- **Header:** `Authorization: Bearer <token>`, role: `admin`
- **Deskripsi:** Mendapatkan detail Category (termasuk jika soft deleted).
- **Response:**
  ```json
  {
    "message": "Category detail fetched successfully.",
    "data": {
      "id": 1,
      "name": "Action",
      "description": "Film bergenre aksi",
      "created_at": "...",
      "updated_at": "...",
      "deleted_at": null
    }
  }
  ```

#### 3. Tambah Category
- **URL:** `POST /api/admin/categories`
- **Header:** `Authorization: Bearer <token>`, role: `admin`
- **Deskripsi:** Menambahkan Category baru.
- **Body:**
  ```json
  {
    "category_name": "Horror",
    "description": "Film bergenre horor"
  }
  ```
- **Response:**
  ```json
  {
    "message": "Category created successfully.",
    "data": { ... }
  }
  ```

#### 4. Edit Category
- **URL:** `PUT /api/admin/categories/{id}`
- **Header:** `Authorization: Bearer <token>`, role: `admin`
- **Deskripsi:** Memperbarui data Category.
- **Body:**
  ```json
  {
    "category_name": "Horror Baru",
    "description": "Deskripsi baru"
  }
  ```
- **Response:**
  ```json
  {
    "message": "Category updated successfully.",
    "data": { ... }
  }
  ```

#### 5. Hapus Category
- **URL:** `DELETE /api/admin/categories/{id}`
- **Header:** `Authorization: Bearer <token>`, role: `admin`
- **Deskripsi:** Soft delete Category. Gunakan `?force=true` untuk hard delete.
- **Response (Soft Delete):**
  ```json
  {
    "message": "Category soft deleted.",
    "data": null
  }
  ```
- **Response (Hard Delete):**
  ```json
  {
    "message": "Category permanently deleted.",
    "data": null
  }
  ```

---
