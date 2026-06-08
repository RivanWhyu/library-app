# Sistem Perpustakaan

Sistem Perpustakaan berbasis **REST API** yang dibangun menggunakan **Laravel 13** dan **Laravel Sanctum** untuk memenuhi tugas **UTS Pemrograman WEB Fuulstack**.

Sistem menerapkan **Authentication**, **Role-Based Access Control (RBAC)**, relasi database, serta pengelolaan peminjaman buku dan denda keterlambatan.

---
# Dokumen Pengumpulan UTS
- [Laporan dan Testing Postman](./docs/DOKUMENTASI-BACKEND-SISTEM-PERPUSTAKAAN.pdf)
- [Postman Collection](./Test_API_Libraru-APP.json)
---

# Fitur Sistem

## Admin (Pustakawan)

- Login
- Kelola Data Buku (CRUD)
- Melihat Data Anggota
- Menghapus Anggota
- Melihat Semua Transaksi Peminjaman
- Menyetujui (Approve) Peminjaman Buku
- Memproses Pengembalian Buku
- Melihat Data Denda

## User (Anggota)

- Registrasi Akun
- Login & Logout
- Melihat Profil
- Mengajukan Peminjaman Buku
- Melihat Riwayat Peminjaman

---
# Instalasi Project

## 1. Clone Repository

```bash
git clone https://github.com/RivanWhyu/library-app.git
```

Masuk ke folder project:

```bash
cd library-app
```

---

## 2. Install Dependency

```bash
composer install
```

---

## 3. Copy File Environment

Windows:

```bash
copy .env.example .env
```

Linux/Mac:

```bash
cp .env.example .env
```

---

## 4. Generate Application Key

```bash
php artisan key:generate
```

---

## 5. Konfigurasi Database

Edit file `.env`

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=library-app
DB_USERNAME=root
DB_PASSWORD=
```

Sesuaikan dengan database lokal Anda.

---

## 6. Jalankan Migration

```bash
php artisan migrate
```

---

## 7. Jalankan Seeder Admin

```bash
php artisan db:seed --class=AdminSeeder
```

---

## 8. Jalankan Server

```bash
php artisan serve
```

Server akan berjalan pada:

```text
http://127.0.0.1:8000
```

# Akun Admin Default

```text
Email    : admin@library.com
Password : password
```

---

# 📡 Endpoint API

## Authentication

| Method | Endpoint |
|----------|----------|
| POST | /api/register |
| POST | /api/login |
| POST | /api/logout |
| GET | /api/profile |

---

## Books

| Method | Endpoint |
|----------|----------|
| GET | /api/books |
| POST | /api/books |
| GET | /api/books/{id} |
| PUT | /api/books/{id} |
| DELETE | /api/books/{id} |

---

## Members

| Method | Endpoint |
|----------|----------|
| GET | /api/members |
| GET | /api/members/{id} |
| DELETE | /api/members/{id} |

---

## Borrowings

| Method | Endpoint |
|----------|----------|
| POST | /api/borrowings |
| GET | /api/borrowings |
| GET | /api/my-borrowings |
| PUT | /api/borrowings/{id}/approve |
| PUT | /api/borrowings/{id}/return |

---

## Fines

| Method | Endpoint |
|----------|----------|
| GET | /api/fines |

---

# Struktur Folder Penting

```text
app/
├── Http/
│   ├── Controllers/
│   │   └── Api/
│   └── Middleware/
│
├── Models/
│   ├── User.php
│   ├── Book.php
│   ├── Borrowing.php
│   └── Fine.php
│
database/
├── migrations/
├── seeders/
│   └── AdminSeeder.php
│
routes/
└── api.php
```
---

# Teknologi yang Digunakan

- PHP 8.4+
- Laravel 13
- Laravel Sanctum
- MySQL

---
