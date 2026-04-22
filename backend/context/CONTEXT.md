# Project Context — Sapi Berkah Amanah (Backend)

Dokumen ini adalah referensi teknis project backend Laravel untuk sesi kerja selanjutnya.

---

## Stack & Overview

- **Framework**: Laravel 11 (^11.31), PHP 8.2
- **Database**: MySQL (`DB_DATABASE=sbamanah`)
- **Auth**: Session/Guard `web` untuk panel admin, Laravel Sanctum untuk API
- **Media Storage**: Cloudinary (foto & video hewan kurban)
- **Data Reseller**: Google Apps Script (Google Sheets — bukan database lokal)

**Tujuan Project:**
Sistem manajemen hewan kurban *Sapi Berkah Amanah* dengan dua sisi:
1. **Panel admin** berbasis Blade — untuk kelola data hewan kurban dan lihat data reseller
2. **REST API publik** — dikonsumsi oleh frontend SPA (port default `localhost:5174`)

---

## Struktur Folder Penting

```
backend/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── Admin/                    # Controller panel admin (Blade)
│   │   │   │   ├── DashboardController.php
│   │   │   │   ├── HewanKurbanController.php  ← Hanya untuk respon Blade
│   │   │   │   └── ResellerController.php     ← fetch data dari Google Sheets
│   │   │   ├── Api/                      # Controller untuk REST API JSON
│   │   │   │   ├── AuthController.php         ← Generate token Sanctum
│   │   │   │   └── HewanKurbanController.php  ← Endpoint publik (/hewan-kurban)
│   │   │   └── AdminAuthController.php   ← Auth Web Panel / Session
│   │   ├── Middleware/
│   │   └── Requests/Auth/LoginRequest.php
│   ├── Models/
│   │   ├── HewanKurban.php               ← Berisi logika kategori otomatis (saving event)
│   │   ├── HewanKurbanPhoto.php
│   │   └── User.php
│   ├── Providers/AppServiceProvider.php
│   └── Services/
│       ├── HewanKurbanService.php        ← Logika bisnis CRUD (dipakai di Admin Web & API)
│       └── MediaUploadService.php        ← Service upload/delete ke Cloudinary
├── config/
├── database/
├── resources/views/
│   ├── admin/
│   ├── auth/login.blade.php      ← halaman login admin
│   └── layouts/
└── routes/
    ├── api.php   ← API routes untuk frontend (memakai Api\* Controller)
    └── web.php   ← Web routes panel admin
```

---

## Auth System

### Web (Panel Admin Blade)
- **Guard**: `web` (session-based, driver default Laravel)
- **Controller utama**: `AdminAuthController`
- **Flow**: `Auth::attempt([email, password, is_admin => true])` → session ditetapkan. Root `/` otomatis dilempar ke `/login`.

### API (Sanctum)
- **Guard**: `auth:sanctum` (token Bearer)
- **Controller utama**: `Api\AuthController`
- **Flow**: Memanggil `POST /api/admin/login` -> akan mengembalikan token Sanctum secara eksklusif (berbentuk JSON `token`).
- Token ini nanti digunakan di header `Authorization: Bearer ...` oleh Frontend SPA.

### Ringkasan Proteksi Route

| Jenis | Middleware | Route |
|-------|-----------|-------|
| Panel admin (web) | `auth` (guard web) | `/admin/*` |
| Admin API | `auth:sanctum` | Endpoint terbatas di `api/admin/*` |
| Publik | Tidak ada | `/api/hewan-kurban`, `/api/daftar-reseller` |

---

## Models & Relasi

### `User`
- Kolom: `is_admin` (boolean, default `false`)
- Traits: `HasApiTokens` (Sanctum)

### `HewanKurban`
- **Atribut Utama**: `jenis_sapi`, `umur`, `berat`, `harga`, `kategori`, `deskripsi`
- **Business Logic Event**: Event `saving` akan otomatis menghitung kategori berdasarkan nilai input `berat`:
  - **prime**: berat < 500 kg
  - **bigboss**: berat 500–699 kg
  - **sultan**: berat ≥ 700 kg
- **Relasi**: `hasMany(HewanKurbanPhoto::class)`

### `HewanKurbanPhoto`
- Fitur: Setiap foto memiliki relasi `belongsTo(HewanKurban)` dan atribut `url` (Cloudinary).

---

## API & Web Endpoints

### API Publik (JSON) - `app/Http/Controllers/Api`
| Method | URL | Controller | Keterangan |
|--------|-----|-----------|------------|
| GET | `/api/hewan-kurban` | `Api\HewanKurbanController@index` | Fetch semua katalog. |
| GET | `/api/hewan-kurban/{id}` | `Api\HewanKurbanController@show` | Detail per hewan kurban. |
| POST | `/api/daftar-reseller` | `ResellerController@store` | Diteruskan ke Google Apps Script |

### API Admin (JSON + Sanctum)
| Method | URL | Controller | Keterangan |
|--------|-----|-----------|------------|
| POST | `/api/admin/login` | `Api\AuthController@login` | Generate Token Sanctum |
| POST | `/api/admin/logout` | `Api\AuthController@logout` | Revoke Current Token |

### Web Routes (Blade, butuh Session Auth) - `app/Http/Controllers/Admin`
| Method | URL | Controller | Route Name |
|--------|-----|-----------|------------|
| POST | `/login` / `/logout` | `AdminAuthController` | — |
| GET | `/admin/hewan-kurban/` | `HewanKurbanController` | `admin.hewan-kurban.index` - (Create, Store, Edit, Update, Destroy) |
| DELETE | `/admin/hewan-kurban/photo/{id}`| `HewanKurbanController` | `admin.hewan-kurban.photo.delete` |

---

## Catatan Penting

### 1. Service Pattern (`HewanKurbanService`)
Operasi Create, Update, dan Delete untuk model `HewanKurban` wajib dikoordinasikan lewat `HewanKurbanService` (mengatasi transaksi database, serta unggah/hapus media). **Dilarang keras** memasukkan logika ini di Controller, agar implementasi API dan Web Controller murni hanya untuk *Response Formatting*.

### 2. Data reseller disimpan di Google Sheets
Tidak ada tabel reseller di database lokal saat ini. 

### 3. MediaUploadService Workaround
Library Cloudinary sekarang memakai 2 instance. Walaupun ini kurang optimal (blackbox `UploadApi` dan manual `new Cloudinary()`), biarkan ini *as-is* untuk mengurangi resiko regresi selama fase-fase awal, karena fungsionalitasnya sudah berjalan baik.

### 4. Kredensial admin default (dari seeder)
- Email: `admin@example.com`
- Password: `admin123`

---

## Status Terakhir (Akhir Fase Cleanup)
- **Refactoring CLEANUP Selesai:** Controller Web/API sudah displit, Logika Kategori di Model, Implementasi Service Class, Autentikasi API mandiri menggunakan tipe Token, dan bug/prefix unused dihapus. Aplikasi siap masuk ke implementasi **Fase 1**.
