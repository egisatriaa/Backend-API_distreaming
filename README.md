# 🎬 Distreaming Backend (Laravel 12 API)

Aplikasi backend untuk platform streaming film berbasis Laravel 12. Menyediakan API lengkap untuk **manajemen film & kategori (admin)** dan **penjelajahan film (user & guest)** dengan fitur soft delete, rating, watch history, dan autentikasi berbasis Sanctum.

[Link Github](https://github.com/egisatriaa/Backend-API_distreaming)

---

## 📌 Fitur Utama

### 🔐 **Autentikasi**

-   Register & Login (Sanctum)
-   Role-based: **User** dan **Admin**
-   Middleware `admin` untuk proteksi route

### 🎬 **Manajemen Film (Admin)**

-   CRUD lengkap dengan **soft delete** dan **hard delete**
-   Hard delete hanya bisa dilakukan pada film yang sudah di-soft delete
-   Validasi input melalui Form Request
-   Attach/detach kategori

### 🏷️ **Manajemen Kategori (Admin)**

-   CRUD dengan soft delete
-   Integrasi dengan film

### 👥 **Fitur User**

-   Lihat daftar film (dengan search, filter kategori, sorting, pagination)
-   Beri rating pada film
-   Tambah ke watch history
-   Lihat riwayat tontonan

### 🌍 **Akses Publik (Guest)**

-   Lihat daftar film (tanpa login)
-   Lihat detail film

### 💾 **ERD dan Database**

[Klik disini untuk melihat tabel dan ERD](https://github.com/egisatriaa/mini-project-diStreaming_SQL-ERD)

-   Soft delete untuk `movies` dan `categories`
-   Relasi many-to-many antara film dan kategori
-   Rating dan watch history terpisah per user

---

## 🛠️ Prasyarat

-   PHP >= 8.2
-   Composer
-   MySQL / MariaDB
-   Node.js (opsional, untuk frontend)
-   Postman (untuk testing)

---

## 🚀 Instalasi

### 1. Clone Repository

```bash
git clone https://github.com/egisatriaa/Backend-API_distreaming.git
cd distreaming_backend
```

### 2. Install Dependencies

```bash
composer install
```

### 3. Edit file .env sesuai environment

```bash
APP_NAME="Distreaming API"
APP_ENV=local
APP_KEY=
APP_DEBUG=true
APP_URL=http://localhost:8000

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=distreaming_db
DB_USERNAME=root
DB_PASSWORD=
```

### 4. Jalankan Migration & Seeder

```bash
php artisan migrate --seed
```

-   Seeder akan membuat:

-   -   1 akun admin: admin@example.com
        password : admin123
-   -   1 akun user: user@example.com
        password: user123
-   -   Data film & kategori contoh (dari seeder)

### 5. Jalankan Server

```bash
php artisan serve
```

Aplikasi siap diakses di:

```bash
http://localhost:8000
```

## 🔒 Autentikasi

-   Login: POST /api/login → mengembalikan token Sanctum
-   Guest: Tidak perlu login (route /api/guest/\*\*)

-   User: Gunakan header Authorization: Bearer <token>
-   Admin: Hanya bisa diakses oleh user dengan role admin

## 🧪 Testing dengan Postman

Saya menyediakan Postman Collection yang sudah lengkap untuk semua endpoint:
[Distreaming API - Postman Collection](https://fullstack-web-developer-batch-1.postman.co/workspace/Team-Workspace~6ec01e2f-5ac2-4179-80b6-d52ee663d019/collection/48609384-f0a0851c-5a21-4cb1-b9e9-bf871342ef71?spm=a2ty_o01.29997173.0.0.5ebf5171CrGkkt&action=share&creator=48609384)

### Langkah Penggunaan:

1. Import collection ke Postman
2. Set environment variable base_url = http://localhost:8000
3. Jalankan alur:

-   Authentication → login sebagai admin/user
    -> Admin → kelola film & kategori
    -> User → beri rating, lihat watch history
    -> Guest → jelajahi film

## 📝 Catatan Tambahan

-   Semua respons API mengikuti format

```
{
  "success": true,
  "message": "Deskripsi",
  "data": { ... }
}
```

-   Error handling konsisten (404, 422, 400, dll)
-   Soft delete film/kategori tidak muncul di sisi user/guest
-   Rating dihitung rata-rata dengan 1 desimal (8.0, 7.5, dll)

## 🙌 Dikembangkan Oleh

Egi Satria
Junior Full Stack Developer
📧 egi.satriadyw@gmail.com

🚀 Happy coding! Jika ada pertanyaan, silakan buka issue atau hubungi developer.
