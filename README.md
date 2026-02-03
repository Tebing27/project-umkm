# Sistem Manajemen UMKM (Sasuma)

> Sistem Manajemen UMKM (Usaha Mikro Kecil Menengah) - Platform Direktori Usaha Kecil

![Laravel](https://img.shields.io/badge/Laravel-12.x-FF2D20?style=flat&logo=laravel&logoColor=white)
![PHP](https://img.shields.io/badge/PHP-8.2+-777BB4?style=flat&logo=php&logoColor=white)
![MySQL](https://img.shields.io/badge/MySQL-8.0-4479A1?style=flat&logo=mysql&logoColor=white)
![Tailwind CSS](https://img.shields.io/badge/Tailwind-4.x-06B6D4?style=flat&logo=tailwindcss&logoColor=white)

---

## Daftar Isi

1. [Gambaran Proyek](#-gambaran-proyek)
2. [Fitur](#-fitur)
   - [Fitur Pengguna](#fitur-pengguna)
   - [Fitur Admin](#fitur-admin)
   - [Fitur Publik](#fitur-publik)
   - [Fitur Bisnis & Monetisasi](#fitur-bisnis--monetisasi)
   - [Fitur Sistem](#fitur-sistem)
3. [Stack Teknologi](#-stack-teknologi)
4. [Skema Database & ERD](#-skema-database--erd)
5. [Konfigurasi Environment](#-konfigurasi-environment)
6. [Instalasi](#-instalasi)
   - [Development Lokal (Docker)](#development-lokal-docker)
   - [Deployment Shared Hosting](#deployment-shared-hosting)
7. [Logika & Alur Aplikasi](#-logika--alur-aplikasi)
8. [Konfigurasi Cronjob](#-konfigurasi-cronjob)
9. [Referensi Perintah](#-referensi-perintah)
10. [Struktur Proyek](#-struktur-proyek)
11. [API & Layanan Eksternal](#-api--layanan-eksternal)
12. [Pemecahan Masalah](#-pemecahan-masalah)

---

## Gambaran Proyek

**Sistem Manajemen UMKM** adalah platform berbasis Laravel yang komprehensif untuk mengelola usaha kecil (UMKM - Usaha Mikro Kecil Menengah) di Indonesia. Sistem ini menyediakan ekosistem lengkap untuk pendaftaran bisnis, verifikasi, manajemen produk, dan pencarian publik.

### Kemampuan Utama

- **Direktori Bisnis:** Daftar publik usaha kecil yang terverifikasi
- **Verifikasi Admin:** Kontrol kualitas melalui verifikasi toko secara manual
- **Showcase Produk:** Galeri produk multi-gambar dengan kategori
- **Pencarian Geografis:** Filter berbasis wilayah dan peta interaktif
- **Multi-bahasa:** Dukungan Bahasa Indonesia dan Inggris dengan terjemahan AI
- **Update Real-time:** Notifikasi langsung via Firebase Realtime Database
- **Optimasi SEO:** Pembuatan sitemap otomatis dan meta tag
- **Penyimpanan Cloud:** Integrasi Cloudinary untuk hosting gambar yang skalabel

### Target Pengguna

1. **Pemilik UMKM:** Mendaftar dan mengelola profil bisnis mereka
2. **Administrator:** Memverifikasi dan memoderasi daftar bisnis
3. **Pengunjung Publik:** Menemukan dan menjelajahi bisnis lokal

---

## Fitur

### Fitur Pengguna

**Manajemen Akun**

- Verifikasi email diperlukan
- Profil dengan detail pribadi (nama, telepon, tanggal lahir, alamat)
- Fungsi reset password

**Manajemen Toko**

- Satu toko per akun pengguna
- Detail bisnis (nama, deskripsi, jenis, rentang omzet)
- Lokasi geografis dengan penandaan peta
- Link media sosial (Instagram, TikTok, Facebook, Website)
- Upload izin usaha
- Upload logo toko (dihost di Cloudinary)

**Manajemen Produk**

- Produk tak terbatas per toko
- Detail produk (nama, harga, kategori, varian, deskripsi)
- Galeri multi-gambar per produk
- Toggle status aktif/tidak aktif
- Penandaan produk terlaris
- Dukungan upload gambar batch

**Galeri Foto**

- Hingga 5 foto toko
- Pengurutan drag-and-drop
- Pengiriman CDN Cloudinary
- Srcset gambar responsif

### Fitur Admin

**Sistem Verifikasi Toko**

- Review toko yang menunggu
- Setuju/tolak dengan alasan
- Pengecekan kelengkapan otomatis
- Pelacakan status verifikasi

**Manajemen Pengguna**

- Lihat semua pengguna terdaftar
- Inspeksi detail pengguna
- Pelacakan asosiasi toko

**Manajemen Konten (CMS)**

- Jenis bisnis dinamis
- Fallback logo per jenis bisnis
- Gambar hero untuk homepage
- Gambar banner index UMKM
- Blok konten teks

**Manajemen Wilayah**

- Konfigurasi area geografis
- Pemilihan toko unggulan per wilayah
- Gambar wilayah dan koordinat
- Pengurutan carousel hero

**Slider Wilayah Unggulan (Siap Monetisasi)**

- Highlight toko kustom per wilayah untuk slider hero homepage
- Admin dapat memilih UMKM spesifik untuk ditampilkan dari setiap wilayah
- Urutan tampilan yang dapat dikonfigurasi untuk carousel hero
- **Potensi Bisnis:** Dapat dimonetisasi sebagai "penempatan bersponsor" atau "listing premium"
- Toko dapat membayar untuk ditampilkan secara menonjol di homepage per wilayah mereka

### Fitur Publik

**Penemuan Bisnis**

- Direktori toko yang dapat dicari
- Filter berdasarkan jenis bisnis
- Filter berdasarkan wilayah
- Tampilan badge terverifikasi
- Pelacakan penghitung tampilan

**Halaman Detail Toko**

- Informasi bisnis lengkap
- Slider galeri foto
- Katalog produk dengan gambar
- Link media sosial
- Peta dengan lokasi tepat

**Homepage**

- Carousel hero dengan toko unggulan
- Showcase wilayah dengan jumlah toko
- Peta interaktif dengan semua toko terverifikasi
- Kategori jenis bisnis

### Fitur Bisnis & Monetisasi

**Sistem Slider Wilayah Unggulan**

Slider Wilayah Unggulan (`featured-region-card.blade.php`) adalah fitur admin yang powerful yang memungkinkan monetisasi bisnis:

**Cara Kerjanya:**

```
Panel Admin → Manajemen Konten → Konfigurasi Wilayah
                     ↓
   ┌─────────────────────────────────────────────────────────────┐
   │  KARTU WILAYAH (per wilayah)                                │
   │  ┌───────────────────────────────────────────────────────┐  │
   │  │ [Gambar Wilayah] [Nama Wilayah]         Urutan: [#1]  │  │
   │  │                                                       │  │
   │  │ Toko Unggulan: [▼ Pilih UMKM dari wilayah ini     ]   │  │
   │  │                                                       │  │
   │  │                                     [Tombol Simpan]   │  │
   │  └───────────────────────────────────────────────────────┘  │
   └─────────────────────────────────────────────────────────────┘
                     ↓
   Slider Hero Homepage menampilkan toko unggulan secara berurutan
```

**Fitur Utama:**

| Fitur | Deskripsi | Nilai Bisnis |
|-------|-----------|--------------|
| **Pemilihan Toko Kustom** | Admin dapat memilih secara manual toko mana yang muncul sebagai "unggulan" untuk setiap wilayah | Penempatan premium untuk UMKM berbayar |
| **Kontrol Urutan Tampilan** | Atur `hero_order` untuk mengontrol urutan slider | Posisi prioritas (#1, #2, dll.) |
| **Opsi Acak/Tidak Ada** | Opsi "Acak / Tidak Ada" untuk perilaku default | Tier gratis atau tampilan berputar |
| **Berbasis Wilayah** | Hanya menampilkan toko yang berada di wilayah tersebut | Iklan berbasis lokasi |
| **Pencarian Real-time** | Dropdown yang dapat dicari untuk pemilihan toko yang mudah | Efisiensi admin |

**Strategi Monetisasi:**

1. **Paket Penempatan Bersponsor**
   - Kenakan biaya bulanan/tahunan kepada UMKM untuk ditampilkan di homepage
   - Contoh: Rp 100.000/bulan untuk status "Bisnis Unggulan"

2. **Listing Wilayah Prioritas**
   - Nomor `hero_order` lebih tinggi = lebih belakang di carousel
   - Jual spot premium "Posisi #1" per wilayah

3. **Spotlight Berputar**
   - Gunakan "Acak" untuk pengguna tier gratis
   - Penempatan terjamin untuk pelanggan berbayar

4. **Kampanye Regional**
   - Bermitra dengan pemerintah atau asosiasi lokal
   - Tampilkan beberapa bisnis dari satu wilayah selama festival/event

**Implementasi Teknis:**

Terletak di: `laravel_app/resources/views/admin/content/partials/featured-regions/`
- `featured-region-card.blade.php` - Komponen kartu utama dengan state Alpine.js
- `featured-region-header.blade.php` - Nama wilayah, gambar, dan input urutan
- `featured-region-dropdown.blade.php` - Dropdown pemilih toko yang dapat dicari
- `featured-region-submit.blade.php` - Tombol simpan dengan state loading

Controller: `App\Http\Controllers\Admin\RegionController@updateFeaturedShop`
Model: `Region` dengan foreign key `featured_shop_id` ke tabel `shops`

---

### Fitur Sistem

**Dukungan Multi-bahasa**

- Bahasa Indonesia (default)
- Terjemahan Bahasa Inggris via OpenRouter AI
- Terjemahan deskripsi toko otomatis
- Terjemahan yang di-cache untuk performa

**Optimasi SEO**

- Pembuatan sitemap.xml dinamis
- Konfigurasi robots.txt
- Meta tag untuk semua halaman
- URL kanonik
- Dukungan structured data

**Update Real-time**

- Integrasi Firebase Realtime Database untuk notifikasi langsung
- Update status verifikasi toko
- Broadcast update konten
- Perubahan status pengguna

**Performa**

- Optimasi query database
- Eager loading relationship
- Pengiriman gambar via CDN
- Response caching
- Optimasi index pada kolom dengan traffic tinggi

---

## Stack Teknologi

### Backend

- **Framework:** Laravel 12.x (PHP 8.2+)
- **Database:** MySQL 8.0
- **Sistem Queue:** Queue berbasis database
- **Cache:** Driver cache database
- **Session:** Penyimpanan session database

### Frontend

- **Template Engine:** Blade
- **Framework CSS:** Tailwind CSS 4.x
- **JavaScript:** Alpine.js (reaktivitas ringan)
- **Build Tool:** Vite
- **Ikon:** Heroicons

### Layanan Eksternal

- **Penyimpanan Gambar:** Cloudinary (CDN cloud)
- **Real-time:** Firebase Realtime Database (notifikasi WebSocket)
- **Email:** SMTP (Gmail dikonfigurasi)
- **Terjemahan AI:** OpenRouter API
- **Database (opsional):** Firebase Realtime Database

### Alat Development

- **Containerization:** Docker + Docker Compose
- **Package Manager:** Composer (PHP), NPM (JavaScript)
- **Kualitas Kode:** Laravel Pint (code style)
- **Testing:** PHPUnit
- **Admin Database:** phpMyAdmin (Docker)

### Kebutuhan Production

- **PHP:** >= 8.2
- **MySQL:** >= 8.0 (atau MariaDB >= 10.3)
- **Ekstensi:** BCMath, Ctype, Fileinfo, JSON, Mbstring, OpenSSL, PDO, Tokenizer, XML
- **Composer:** Versi terbaru
- **Node.js:** >= 18 (untuk kompilasi aset)

---

## Skema Database & ERD

### Diagram Entity-Relationship

```
┌──────────────┐         ┌──────────────┐         ┌──────────────┐
│    USERS     │1      1 │    SHOPS     │1      ∞ │   PRODUCTS   │
│──────────────│────────▶│──────────────│────────▶│──────────────│
│ id (PK)      │         │ id (PK)      │         │ id (PK)      │
│ name         │         │ user_id (FK) │         │ shop_id (FK) │
│ email        │         │ name         │         │ name         │
│ password     │         │ description  │         │ price        │
│ phone_number │         │ business_type│         │ category     │
│ role         │         │ product_type │         │ image        │
│ email_verified         │ region_id(FK)│         │ variant      │
│ place_of_birth         │ address      │         │ description  │
│ date_of_birth│         │ latitude     │         │ is_active    │
│ domicile_addr│         │ longitude    │         │ is_best_seller
└──────────────┘         │ omset_min    │         └──────────────┘
                         │ omset_max    │                │1
                         │ logo         │                │
                         │ is_verified  │                │∞
                         │ rejection_   │         ┌───────────────┐
                         │  reason      │         │ PRODUCT_      │
                         │ licenses     │         │  IMAGES       │
                         │ social_*     │         │───────────────│
                         │ views        │         │ id (PK)       │
                         └──────────────┘         │ product_id(FK)│
                                │1                │ image         │
                                │                 │ sort_order    │
                                │∞                └───────────────┘
                         ┌──────────────┐
                         │ SHOP_PHOTOS  │
                         │──────────────│
                         │ id (PK)      │
                         │ shop_id (FK) │
                         │ path         │
                         │ order        │
                         └──────────────┘

┌──────────────┐         ┌──────────────┐
│   REGIONS    │1      ∞ │    SHOPS     │
│──────────────│◀────────│ (lihat atas) │
│ id (PK)      │         └──────────────┘
│ name         │
│ image        │         ┌──────────────┐
│ latitude     │         │  CONTENTS    │
│ longitude    │         │──────────────│
│ featured_shop│         │ id (PK)      │
│  _id (FK)    │         │ key          │
│ hero_order   │         │ value        │
└──────────────┘         │ type         │
                         │ group        │
                         │ label        │
                         └──────────────┘

┌──────────────┐
│ TRANSLATIONS │
│──────────────│
│ id (PK)      │
│ text         │
│ language     │
│ translated   │
└──────────────┘
```

### Deskripsi Tabel

#### 1. **users** - Akun Pengguna

| Kolom             | Tipe            | Nullable | Deskripsi                    |
| ----------------- | --------------- | -------- | ---------------------------- |
| id                | BIGINT UNSIGNED | NO       | Primary key (auto-increment) |
| name              | VARCHAR(255)    | NO       | Nama lengkap                 |
| email             | VARCHAR(255)    | NO       | Alamat email unik            |
| password          | VARCHAR(255)    | NO       | Password ter-hash (bcrypt)   |
| phone_number      | VARCHAR(20)     | YES      | Nomor kontak                 |
| role              | VARCHAR(50)     | NO       | 'admin' atau 'users'         |
| email_verified_at | TIMESTAMP       | YES      | Timestamp verifikasi email   |
| place_of_birth    | VARCHAR(255)    | YES      | Tempat lahir                 |
| date_of_birth     | DATE            | YES      | Tanggal lahir                |
| domicile_address  | TEXT            | YES      | Alamat sekarang              |
| remember_token    | VARCHAR(100)    | YES      | Token session                |
| created_at        | TIMESTAMP       | YES      | Pembuatan record             |
| updated_at        | TIMESTAMP       | YES      | Update terakhir              |

**Index:**

- PRIMARY KEY: `id`
- UNIQUE: `email`

**Relationship:**

- Has One: `shops`

---

#### 2. **shops** - Profil Bisnis

| Kolom            | Tipe            | Nullable | Deskripsi                                  |
| ---------------- | --------------- | -------- | ------------------------------------------ |
| id               | BIGINT UNSIGNED | NO       | Primary key (auto-increment)               |
| user_id          | BIGINT UNSIGNED | NO       | Foreign key ke users                       |
| name             | VARCHAR(255)    | NO       | Nama bisnis                                |
| description      | TEXT            | YES      | Deskripsi bisnis                           |
| product_type     | VARCHAR(255)    | YES      | Kategori produk utama                      |
| business_type    | VARCHAR(255)    | YES      | Klasifikasi bisnis                         |
| region_id        | BIGINT UNSIGNED | YES      | Foreign key ke regions                     |
| address          | TEXT            | YES      | Alamat lengkap                             |
| latitude         | DECIMAL(10,8)   | YES      | Latitude GPS                               |
| longitude        | DECIMAL(11,8)   | YES      | Longitude GPS                              |
| omset_min        | BIGINT          | YES      | Omzet minimum                              |
| omset_max        | BIGINT          | YES      | Omzet maksimum                             |
| logo             | VARCHAR(500)    | YES      | Path gambar logo (Cloudinary)              |
| is_verified      | BOOLEAN         | NO       | Status verifikasi admin (default: false)   |
| rejection_reason | TEXT            | YES      | Pesan penolakan admin                      |
| licenses         | JSON            | YES      | Array izin usaha                           |
| social_instagram | VARCHAR(255)    | YES      | URL/username Instagram                     |
| social_tiktok    | VARCHAR(255)    | YES      | URL/username TikTok                        |
| social_facebook  | VARCHAR(255)    | YES      | URL/username Facebook                      |
| social_website   | VARCHAR(255)    | YES      | URL Website                                |
| views            | INTEGER         | NO       | Penghitung tampilan (default: 0)           |
| created_at       | TIMESTAMP       | YES      | Pembuatan record                           |
| updated_at       | TIMESTAMP       | YES      | Update terakhir                            |

**Index:**

- PRIMARY KEY: `id`
- FOREIGN KEY: `user_id` → users(id) ON DELETE CASCADE
- FOREIGN KEY: `region_id` → regions(id) ON DELETE SET NULL
- INDEX: `is_verified` (filtering)
- INDEX: `business_type` (filtering)
- INDEX: `views` (sorting)
- FULLTEXT: `name, description` (search)

**Relationship:**

- Belongs To: `users`, `regions`
- Has Many: `products`, `shop_photos`

---

#### 3. **products** - Produk Toko

| Kolom          | Tipe            | Nullable | Deskripsi                         |
| -------------- | --------------- | -------- | --------------------------------- |
| id             | BIGINT UNSIGNED | NO       | Primary key (auto-increment)      |
| shop_id        | BIGINT UNSIGNED | NO       | Foreign key ke shops              |
| name           | VARCHAR(255)    | NO       | Nama produk                       |
| price          | DECIMAL(12,2)   | NO       | Harga produk                      |
| category       | VARCHAR(255)    | NO       | Kategori produk                   |
| image          | VARCHAR(500)    | YES      | Path gambar utama (Cloudinary)    |
| variant        | VARCHAR(255)    | YES      | Varian produk                     |
| description    | TEXT            | YES      | Deskripsi produk                  |
| is_active      | BOOLEAN         | NO       | Status aktif (default: true)      |
| is_best_seller | BOOLEAN         | NO       | Flag best seller (default: false) |
| created_at     | TIMESTAMP       | YES      | Pembuatan record                  |
| updated_at     | TIMESTAMP       | YES      | Update terakhir                   |

**Index:**

- PRIMARY KEY: `id`
- FOREIGN KEY: `shop_id` → shops(id) ON DELETE CASCADE
- INDEX: `is_active` (filtering)
- INDEX: `is_best_seller` (filtering)

**Relationship:**

- Belongs To: `shops`
- Has Many: `product_images`

---

#### 4. **product_images** - Galeri Produk

| Kolom      | Tipe            | Nullable | Deskripsi                    |
| ---------- | --------------- | -------- | ---------------------------- |
| id         | BIGINT UNSIGNED | NO       | Primary key (auto-increment) |
| product_id | BIGINT UNSIGNED | NO       | Foreign key ke products      |
| image      | VARCHAR(500)    | NO       | Path gambar (Cloudinary)     |
| sort_order | INTEGER         | NO       | Urutan tampilan (default: 0) |
| created_at | TIMESTAMP       | YES      | Pembuatan record             |
| updated_at | TIMESTAMP       | YES      | Update terakhir              |

**Index:**

- PRIMARY KEY: `id`
- FOREIGN KEY: `product_id` → products(id) ON DELETE CASCADE
- INDEX: `sort_order` (ordering)

**Relationship:**

- Belongs To: `products`

---

#### 5. **shop_photos** - Galeri Foto Toko

| Kolom      | Tipe            | Nullable | Deskripsi                    |
| ---------- | --------------- | -------- | ---------------------------- |
| id         | BIGINT UNSIGNED | NO       | Primary key (auto-increment) |
| shop_id    | BIGINT UNSIGNED | NO       | Foreign key ke shops         |
| path       | VARCHAR(500)    | NO       | Path gambar (Cloudinary)     |
| order      | INTEGER         | NO       | Urutan tampilan (default: 0) |
| created_at | TIMESTAMP       | YES      | Pembuatan record             |
| updated_at | TIMESTAMP       | YES      | Update terakhir              |

**Index:**

- PRIMARY KEY: `id`
- FOREIGN KEY: `shop_id` → shops(id) ON DELETE CASCADE
- INDEX: `order` (ordering)

**Relationship:**

- Belongs To: `shops`

---

#### 6. **regions** - Area Geografis

| Kolom            | Tipe            | Nullable | Deskripsi                    |
| ---------------- | --------------- | -------- | ---------------------------- |
| id               | BIGINT UNSIGNED | NO       | Primary key (auto-increment) |
| name             | VARCHAR(255)    | NO       | Nama wilayah                 |
| image            | VARCHAR(500)    | YES      | Gambar wilayah (Cloudinary)  |
| latitude         | DECIMAL(10,8)   | YES      | Latitude GPS                 |
| longitude        | DECIMAL(11,8)   | YES      | Longitude GPS                |
| featured_shop_id | BIGINT UNSIGNED | YES      | Foreign key ke shops         |
| hero_order       | INTEGER         | YES      | Urutan carousel homepage     |
| created_at       | TIMESTAMP       | YES      | Pembuatan record             |
| updated_at       | TIMESTAMP       | YES      | Update terakhir              |

**Index:**

- PRIMARY KEY: `id`
- FOREIGN KEY: `featured_shop_id` → shops(id) ON DELETE SET NULL
- INDEX: `hero_order` (ordering)

**Relationship:**

- Has Many: `shops`
- Belongs To: `shops` (featured shop)

---

#### 7. **contents** - Konten CMS

| Kolom      | Tipe            | Nullable | Deskripsi                     |
| ---------- | --------------- | -------- | ----------------------------- |
| id         | BIGINT UNSIGNED | NO       | Primary key (auto-increment)  |
| key        | VARCHAR(255)    | NO       | Identifier konten unik        |
| value      | LONGTEXT        | YES      | Nilai konten                  |
| type       | VARCHAR(50)     | NO       | 'text', 'image', 'json', dll. |
| group      | VARCHAR(100)    | YES      | Pengelompokan konten          |
| label      | VARCHAR(255)    | YES      | Label yang mudah dibaca       |
| created_at | TIMESTAMP       | YES      | Pembuatan record              |
| updated_at | TIMESTAMP       | YES      | Update terakhir               |

**Index:**

- PRIMARY KEY: `id`
- UNIQUE: `key`
- INDEX: `group` (filtering)

**Relationship:**

- Tidak ada (konten mandiri)

---

#### 8. **translations** - Cache Terjemahan

| Kolom      | Tipe            | Nullable | Deskripsi                    |
| ---------- | --------------- | -------- | ---------------------------- |
| id         | BIGINT UNSIGNED | NO       | Primary key (auto-increment) |
| text       | TEXT            | NO       | Teks asli                    |
| language   | VARCHAR(10)     | NO       | Kode bahasa target           |
| translated | TEXT            | NO       | Teks terjemahan              |
| created_at | TIMESTAMP       | YES      | Pembuatan record             |
| updated_at | TIMESTAMP       | YES      | Update terakhir              |

**Index:**

- PRIMARY KEY: `id`
- UNIQUE: `text (hash), language` (mencegah duplikat)

**Relationship:**

- Tidak ada (cache terjemahan)

---

### Tabel Sistem Laravel

- **cache** & **cache_locks** - Penyimpanan cache
- **sessions** - Penyimpanan session pengguna
- **jobs** & **job_batches** - Sistem queue
- **failed_jobs** - Log job queue yang gagal
- **password_reset_tokens** - Penyimpanan reset password

### Ringkasan Relationship Database

```
users (1) ────▶ shops (1) ────▶ products (∞) ────▶ product_images (∞)
                  │
                  └────▶ shop_photos (∞)
                  │
regions (1) ──────┘

regions (1) ──featured──▶ shops (1)

contents (mandiri)
translations (mandiri)
```

---

## Konfigurasi Environment

### Variabel .env yang Diperlukan

#### Pengaturan Aplikasi

```env
APP_NAME="UMKM Sasuma"
APP_ENV=production                    # local, staging, production
APP_KEY=base64:YOUR_32_CHAR_KEY      # php artisan key:generate
APP_DEBUG=false                       # HARUS false di production
APP_URL=https://yourdomain.com        # Domain Anda yang sebenarnya

APP_LOCALE=id                         # Bahasa default (id/en)
APP_FALLBACK_LOCALE=en               # Bahasa fallback
```

#### Konfigurasi Database

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1                    # Atau host MySQL Anda
DB_PORT=3306
DB_DATABASE=nama_database_anda
DB_USERNAME=user_database_anda
DB_PASSWORD=password_database_anda
```

#### Konfigurasi Mail (Verifikasi Email)

```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com             # Atau provider SMTP Anda
MAIL_PORT=587
MAIL_USERNAME=email_anda@gmail.com
MAIL_PASSWORD=app_password_anda      # Gmail: App Password diperlukan
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=email_anda@gmail.com
MAIL_FROM_NAME="${APP_NAME}"
```

**Setup Gmail:**

1. Aktifkan 2-Factor Authentication
2. Generate App Password: https://myaccount.google.com/apppasswords
3. Gunakan App Password di `MAIL_PASSWORD`

#### Konfigurasi Cloudinary (Penyimpanan Gambar)

```env
CLOUDINARY_CLOUD_NAME=cloud_name_anda
CLOUDINARY_API_KEY=api_key_anda
CLOUDINARY_API_SECRET=api_secret_anda
CLOUDINARY_URL=cloudinary://api_key:api_secret@cloud_name
```

**Dapatkan Kredensial:**

1. Daftar di https://cloudinary.com
2. Dashboard → Account Details
3. Salin Cloud Name, API Key, API Secret

**Dapatkan Kredensial:**

1. Daftar di https://Firebase
2. Buat app baru → Pilih cluster
3. Salin App ID, Key, Secret dari tab App Keys

#### Konfigurasi Firebase Realtime Database

```env
FIREBASE_DATABASE_URL=https://your-project.firebaseio.com
FIREBASE_API_KEY=firebase_api_key_anda
FIREBASE_AUTH_DOMAIN=your-project.firebaseapp.com
FIREBASE_PROJECT_ID=your-project-id
FIREBASE_STORAGE_BUCKET=your-project.appspot.com
FIREBASE_MESSAGING_SENDER_ID=sender_id_anda
FIREBASE_APP_ID=app_id_anda

VITE_FIREBASE_API_KEY="${FIREBASE_API_KEY}"
VITE_FIREBASE_AUTH_DOMAIN="${FIREBASE_AUTH_DOMAIN}"
VITE_FIREBASE_DATABASE_URL="${FIREBASE_DATABASE_URL}"
VITE_FIREBASE_PROJECT_ID="${FIREBASE_PROJECT_ID}"
VITE_FIREBASE_STORAGE_BUCKET="${FIREBASE_STORAGE_BUCKET}"
VITE_FIREBASE_MESSAGING_SENDER_ID="${FIREBASE_MESSAGING_SENDER_ID}"
VITE_FIREBASE_APP_ID="${FIREBASE_APP_ID}"
```

**Dapatkan Kredensial:**

1. Buka https://console.firebase.google.com
2. Buat atau pilih proyek Anda
3. Project Settings → General → Your apps
4. Klik "Add app" (Web) jika belum
5. Salin nilai konfigurasi Firebase Anda
6. Aktifkan Realtime Database di Firebase Console → Build → Realtime Database

---

#### OpenRouter API (Terjemahan AI)

```env
OPENROUTER_API_KEY=sk-or-v1-api_key_anda
```

**Dapatkan API Key:**

1. Daftar di https://openrouter.ai
2. Account → API Keys → Create Key
3. Tambahkan kredit ke akun

#### Session & Cache

```env
SESSION_DRIVER=database               # Gunakan database untuk shared hosting
SESSION_LIFETIME=120                  # Menit

CACHE_STORE=database                  # Gunakan database untuk shared hosting
```

#### Konfigurasi Queue

```env
QUEUE_CONNECTION=database             # Gunakan database untuk shared hosting
```

```env
FIREBASE_DATABASE_URL=https://your-project.firebaseio.com
```

---

### Variabel .env Opsional

```env
# Logging
LOG_CHANNEL=stack
LOG_LEVEL=error                       # debug, info, warning, error

# Keamanan
BCRYPT_ROUNDS=12                      # Biaya hashing password

# Penyimpanan File
FILESYSTEM_DISK=local                 # local atau cloudinary

# Vite (Development)
VITE_DEV_SERVER_URL=http://localhost:5173
```

---

## Instalasi

### Development Lokal (Docker)

#### Prasyarat

- Docker Desktop terinstal
- Docker Compose terinstal
- Git

#### Langkah-langkah

**1. Clone Repository**

```bash
git clone <url-repo-anda>
cd umkm_project
```

**2. Mulai Container Docker**

```bash
docker-compose up -d
```

Ini memulai:

- **Laravel App:** http://localhost:8000
- **MySQL:** localhost:3307
- **phpMyAdmin:** http://localhost:8001
- **Vite Dev Server:** http://localhost:5174

**3. Akses Container Laravel**

```bash
docker exec -it laravel_app bash
```

**4. Install Dependencies**

```bash
# Di dalam container
composer install
npm install
```

**5. Konfigurasi Environment**

```bash
cp .env.example .env
php artisan key:generate
```

Edit `.env` dengan pengaturan Docker (sudah dikonfigurasi):

```env
DB_CONNECTION=mysql
DB_HOST=mysql
DB_PORT=3306
DB_DATABASE=sasuma_db
DB_USERNAME=umkm
DB_PASSWORD=umkm_sasuma
```

**6. Jalankan Migrasi**

```bash
php artisan migrate
```

**7. Seed Database** (Membuat user test)

```bash
php artisan db:seed
```

Kredensial default:

- Email: `test@example.com`
- Password: `password`

**8. Link Storage**

```bash
php artisan storage:link
```

**9. Build Aset Frontend**

```bash
npm run build
```

**10. Mulai Queue Worker** (Opsional, untuk background jobs)

```bash
# Di terminal terpisah di dalam container
php artisan queue:work
```

**11. Akses Aplikasi**

- Frontend: http://localhost:8000
- phpMyAdmin: http://localhost:8001 (user: `umkm`, pass: `umkm_sasuma`)

---

### Deployment Shared Hosting

#### Prasyarat

- cPanel atau panel hosting serupa
- PHP >= 8.2
- MySQL >= 8.0
- Akses Composer (SSH atau panel)
- Domain dikonfigurasi

#### Langkah-langkah

**1. Siapkan Build Lokal**

```bash
# Di mesin lokal Anda
composer install --optimize-autoloader --no-dev
npm install
npm run build
```

**2. Upload File via FTP/SFTP**

Upload direktori ini:

```
├── app/
├── bootstrap/
├── config/
├── database/
├── lang/
├── public/          ← Document root
├── resources/
├── routes/
├── storage/         ← Set permissions 755
├── vendor/
├── .env.example
├── artisan
├── composer.json
└── composer.lock
```

**JANGAN upload:**

- `.env` (buat secara manual)
- `node_modules/`
- `.git/`
- `tests/`
- `docker/`
- `docker-compose.yml`

**3. Konfigurasi Document Root**

Arahkan domain Anda ke direktori `/public`:

```
Domain: yourdomain.com → /public_html/public
```

**4. Buat File .env**

Di file manager hosting atau SSH:

```bash
cd /home/yourusername/public_html
cp .env.example .env
nano .env  # atau gunakan editor file manager
```

Isi dengan nilai production (lihat bagian Konfigurasi Environment).

**5. Set Permissions Direktori**

```bash
chmod -R 755 storage bootstrap/cache
chmod -R 775 storage/logs
```

**6. Generate Application Key**

```bash
php artisan key:generate
```

**7. Buat Database**

Di cPanel → MySQL Databases:

1. Buat database: `yourusername_umkm`
2. Buat user: `yourusername_umkm`
3. Set password (password kuat)
4. Berikan semua privileges ke user
5. Update `.env` dengan kredensial

**8. Jalankan Migrasi**

```bash
php artisan migrate --force
```

**9. Seed Database**

```bash
php artisan db:seed --force
```

**10. Reset Auto-Increment (Penting!)**

```bash
php artisan db:reset-autoincrement
```

**11. Link Storage**

```bash
php artisan storage:link
```

**12. Clear & Cache Konfigurasi**

```bash
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

**13. Set Ownership** (jika menggunakan SSH)

```bash
chown -R yourusername:yourusername /home/yourusername/public_html
```

**14. Konfigurasi .htaccess** (Biasanya otomatis)

Jika diperlukan, buat `/public/.htaccess`:

```apache
<IfModule mod_rewrite.c>
    RewriteEngine On
    RewriteCond %{REQUEST_FILENAME} !-d
    RewriteCond %{REQUEST_FILENAME} !-f
    RewriteRule ^ index.php [L]
</IfModule>
```

**15. Test Aplikasi**

Kunjungi: `https://yourdomain.com`

---

#### Checklist Pasca-Deployment

- Homepage dimuat tanpa error
- Registrasi berfungsi
- Verifikasi email terkirim
- Login berfungsi
- Gambar terupload ke Cloudinary
- Panel admin dapat diakses
- Koneksi database stabil
- Sitemap ter-generate: `/sitemap.xml`
- Robots.txt ada: `/robots.txt`

---

#### Mengupdate Aplikasi

```bash
# 1. Backup database (cPanel → phpMyAdmin → Export)

# 2. Upload file baru (timpa yang ada)

# 3. Jalankan migrasi
php artisan migrate --force

# 4. Clear cache
php artisan config:clear
php artisan route:clear
php artisan view:clear
php artisan cache:clear

# 5. Rebuild cache
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

---

## Logika & Alur Aplikasi

### Alur Registrasi & Verifikasi Pengguna

```
1. Pengguna mengunjungi /register
   ↓
2. Mengisi form registrasi (nama, email, password, telepon, detail lahir, alamat)
   ↓
3. Sistem membuat akun User (role = 'users', belum terverifikasi)
   ↓
4. Sistem membuat record Shop kosong (terasosiasi dengan user_id)
   ↓
5. Sistem mengirim email verifikasi
   ↓
6. Pengguna klik link email → email_verified_at di-set
   ↓
7. Pengguna diarahkan ke /users/dashboard
```

### Alur Pembuatan & Verifikasi Toko

```
Pengguna (Terverifikasi) → Dashboard
   ↓
1. Navigasi ke "Lokasi"
   - Pilih wilayah dari dropdown
   - Masukkan alamat lengkap
   - Pin lokasi di peta (lat/long)
   - Submit
   ↓
2. Navigasi ke "Edit Toko"
   - Masukkan nama toko
   - Masukkan deskripsi
   - Pilih jenis bisnis
   - Pilih jenis produk
   - Masukkan rentang omzet (omset_min, omset_max)
   - Upload logo
   - Tambahkan link media sosial
   - Upload izin usaha
   - Submit → Job TranslateShopAttributes di-dispatch
   ↓
3. Navigasi ke "Foto"
   - Upload hingga 5 foto toko
   - Urutkan ulang foto dengan drag
   - Submit
   ↓
4. Navigasi ke "Toko" (Produk)
   - Klik "Tambah Produk"
   - Masukkan detail produk (nama, harga, kategori, varian, deskripsi)
   - Upload gambar produk
   - Upload gambar tambahan (multi-image)
   - Submit
   ↓
5. Sistem mengecek kelengkapan:
   ✓ Nama toko ada
   ✓ Deskripsi ada
   ✓ Alamat ada
   ✓ Lat/Long ada
   ✓ Wilayah dipilih
   ✓ Jenis bisnis dipilih
   ✓ Omzet dimasukkan
   ✓ Minimal 1 produk
   ✓ Minimal 1 foto toko
   ↓
6. Jika lengkap:
   - Toko muncul di queue verifikasi admin
   - Status toko: pending (is_verified = false)
   ↓
7. Admin mereview toko:
   Opsi A: SETUJU
     - Set is_verified = true
     - Event ShopUpdated di-dispatch (notifikasi Firebase Realtime Database)
     - Event UserUpdated di-dispatch
     - Toko muncul di listing publik

   Opsi B: TOLAK
     - Set rejection_reason = "Pesan Admin"
     - Event ShopUpdated di-dispatch
     - Pengguna melihat alasan penolakan di dashboard
     - Pengguna dapat mengedit dan mengirim ulang
```

### Logika Verifikasi Admin

**Pengecekan Otomatis (sebelum review admin):**

- Method `Shop::isComplete()` memvalidasi:
  - Semua field wajib terisi
  - Minimal 1 produk ada
  - Minimal 1 foto ada

**Aksi Admin:**

- Setuju: Toko langsung tayang
- Tolak: Pengguna diberitahu, dapat mengedit dan mengirim ulang

**Aturan Pencabutan Otomatis:**
Jika toko terverifikasi menjadi tidak lengkap (misal, pengguna menghapus semua foto):

- `is_verified` otomatis di-set ke `false`
- Memerlukan re-verifikasi admin

### Logika Terjemahan

**Terjemahan Otomatis (Background Job):**

```
Toko diupdate/dibuat
   ↓
Job TranslateShopAttributes di-dispatch
   ↓
Cek apakah terjemahan deskripsi ada di DB
   ↓
Jika tidak: Panggil OpenRouter API (terjemahan AI)
   ↓
Simpan terjemahan ke tabel translations
   ↓
Di-cache untuk penggunaan selanjutnya
```

### Logika Notifikasi Real-time (Firebase Realtime Database)

**Event & Channel:**

```
Event: ShopUpdated
   ↓
Broadcast ke channel: shop.{shop_id}
   ↓
Listener: Dashboard Admin, Dashboard User
   ↓
Aksi: Refresh status verifikasi, update UI

Event: UserUpdated
   ↓
Broadcast ke channel: user.{user_id}
   ↓
Listener: Dashboard User
   ↓
Aksi: Tampilkan notifikasi, refresh data
```

### Logika Upload Gambar

**Alur Upload Cloudinary:**

```
Pengguna memilih gambar (input form)
   ↓
Validasi tipe file (hanya gambar) dan ukuran
   ↓
Upload ke Cloudinary via Laravel facade
   ↓
Cloudinary mengembalikan:
   - public_id
   - secure_url
   - format
   - dimensions
   ↓
Simpan secure_url ke database
   ↓
Tampilkan menggunakan helper storage_url()
```

### Logika SEO Sitemap

**Perintah: `php artisan sitemap:generate`**

```
1. Ambil semua toko terverifikasi
2. Ambil semua produk aktif (dengan toko terverifikasi)
3. Ambil semua jenis bisnis
4. Generate XML dengan:
   - Halaman statis (/, /umkm, /login, /register)
   - Halaman jenis bisnis (/umkm?category=X)
   - Halaman detail toko (/umkm/{id})
   - Halaman detail produk (/umkm/product/{id})
5. Tambahkan timestamp lastmod
6. Simpan ke /public/sitemap.xml
7. Generate /public/robots.txt dengan referensi sitemap
```

**Frekuensi Eksekusi:** Harian via cronjob

---

## Konfigurasi Cronjob

### Cronjob yang Diperlukan untuk Shared Hosting

Laravel memerlukan satu entri cron untuk menjalankan scheduler, yang mengelola semua task terjadwal.

#### 1. Laravel Task Scheduler (Wajib)

Tambahkan ini ke crontab Anda:

```cron
* * * * * cd /home/yourusername/public_html && php artisan schedule:run >> /dev/null 2>&1
```

**Setup cPanel:**

1. cPanel → Advanced → Cron Jobs
2. Common Settings: "Every Minute" (*/1)
3. Command: `cd /home/yourusername/public_html && php artisan schedule:run >> /dev/null 2>&1`
4. Save

**Apa yang dilakukan:**

- Berjalan setiap menit
- Mengecek apakah ada task terjadwal yang harus dieksekusi
- Penggunaan resource minimal

---

#### 2. Konfigurasi Scheduler (Sitemap & Maintenance)

Aplikasi menggunakan scheduler Laravel untuk menangani background task seperti pembuatan sitemap dan pembersihan database.

**Setup Cron Job Tunggal:**

Tambahkan **satu** baris ini ke crontab server Anda (misal, via CPanel atau `crontab -e`) untuk menjalankan semua task terjadwal:

```cron
* * * * * cd /home/yourusername/public_html && php artisan schedule:run >> /dev/null 2>&1
```

_Ganti `/home/yourusername/public_html` dengan path aktual ke proyek Anda._

**Yang ditangani:**

1. **Pembuatan Sitemap:** Berjalan harian pukul 02:00.
2. **Pembersihan Terjemahan:** Berjalan mingguan (Minggu pukul 03:00).

**Trigger Manual:**

```bash
# Generate Sitemap Segera
php artisan sitemap:generate

# Bersihkan Terjemahan Segera
php artisan translations:clean
```

**Output:**

- `/public/sitemap.xml` (pengiriman Google)
- `/public/robots.txt` (konfigurasi SEO)

---

#### 3. Queue Worker (Untuk Background Jobs)

**Opsi A: Worker Terus-menerus (Direkomendasikan untuk VPS)**

```bash
# Jalankan terus di background
nohup php artisan queue:work --sleep=3 --tries=3 --daemon > /dev/null 2>&1 &
```

**Opsi B: Berbasis Cron (Direkomendasikan untuk Shared Hosting)**

```cron
*/5 * * * * cd /home/yourusername/public_html && php artisan queue:work --stop-when-empty >> /dev/null 2>&1
```

**Yang diproses:**

- Job `TranslateShopAttributes` (terjemahan deskripsi toko)
- Pengiriman email (jika menggunakan queue untuk mail)
- Task optimasi gambar

---

### Verifikasi Cronjob Berjalan

**Cek log Laravel:**

```bash
tail -f storage/logs/laravel.log
```

**Test manual:**

```bash
php artisan schedule:list  # Lihat semua task terjadwal
php artisan schedule:run   # Trigger scheduler manual
```

---

## Referensi Perintah

### Manajemen Database

```bash
# Jalankan migrasi
php artisan migrate

# Jalankan migrasi (force, tanpa konfirmasi - production)
php artisan migrate --force

# Rollback migrasi terakhir
php artisan migrate:rollback

# Rollback semua migrasi dan jalankan ulang
php artisan migrate:fresh

# Seed database dengan data sampel
php artisan db:seed

# Seed seeder spesifik
php artisan db:seed --class=DatabaseSeeder

```

---

### Maintenance Aplikasi

```bash
# Generate application key
php artisan key:generate

# Link direktori storage
php artisan storage:link

# Clear semua cache
php artisan optimize:clear
# Sama dengan:
# php artisan cache:clear
# php artisan config:clear
# php artisan route:clear
# php artisan view:clear

# Build cache teroptimasi (production)
php artisan optimize
# Sama dengan:
# php artisan config:cache
# php artisan route:cache
# php artisan view:cache
```

---

### Manajemen Cache

```bash
# Clear cache aplikasi
php artisan cache:clear

# Clear cache konfigurasi
php artisan config:clear

# Clear cache route
php artisan route:clear

# Clear cache view yang dikompilasi
php artisan view:clear

# Cache konfigurasi (production)
php artisan config:cache

# Cache route (production)
php artisan route:cache

# Cache view (production)
php artisan view:cache
```

---

### Manajemen Queue

```bash
# Mulai queue worker (foreground)
php artisan queue:work

# Mulai queue worker dengan opsi
php artisan queue:work --sleep=3 --tries=3 --timeout=90

# Proses semua job lalu stop (shared hosting)
php artisan queue:work --stop-when-empty

# Daftar job yang gagal
php artisan queue:failed

# Retry semua job yang gagal
php artisan queue:retry all

# Retry job gagal spesifik
php artisan queue:retry {id}

# Flush semua job yang gagal
php artisan queue:flush
```

---

### SEO & Sitemap

```bash
# Generate sitemap.xml dan robots.txt
php artisan sitemap:generate
```

**Output:**

- `/public/sitemap.xml`
- `/public/robots.txt`

---

### Alat Development

```bash
# Mulai development server
php artisan serve
# Akses di: http://localhost:8000

# Lihat log real-time
php artisan pail

# Daftar semua route
php artisan route:list

# Daftar semua task terjadwal
php artisan schedule:list

# Jalankan scheduler manual (testing)
php artisan schedule:run

# Laravel Tinker (REPL)
php artisan tinker

# Jalankan test
php artisan test
```

---

### Perintah Composer

```bash
# Install dependencies
composer install

# Install dependencies (production, teroptimasi)
composer install --optimize-autoloader --no-dev

# Update dependencies
composer update

# Dump autoload (setelah menambah class baru)
composer dump-autoload
```

---

### Perintah NPM

```bash
# Install dependencies
npm install

# Development build (watch perubahan)
npm run dev

# Production build (teroptimasi)
npm run build

# Preview production build
npm run preview
```

---

## Struktur Proyek

```
umkm_project/
├── docker/                      # File konfigurasi Docker
│   └── php/
│       └── Dockerfile
├── docker-compose.yml           # Orkestrasi Docker
│
└── laravel_app/                 # Root aplikasi Laravel
    ├── app/
    │   ├── Console/
    │   │   ├── Commands/
    │   │   │   ├── GenerateSitemap.php        # Generator sitemap SEO
    │   │   │   └── CleanTranslations.php      # Pembersihan terjemahan
    │   │
    │   ├── Events/                # Event broadcast Firebase Realtime Database
    │   │   ├── ContentUpdated.php
    │   │   ├── ProductUpdated.php
    │   │   ├── SettingsUpdated.php
    │   │   ├── ShopUpdated.php
    │   │   └── UserUpdated.php
    │   │
    │   ├── Helpers/
    │   │   └── helpers.php         # Fungsi helper global
    │   │
    │   ├── Http/
    │   │   ├── Controllers/
    │   │   │   ├── Admin/
    │   │   │   │   ├── ContentController.php   # Manajemen CMS
    │   │   │   │   └── RegionController.php    # Manajemen wilayah
    │   │   │   ├── Auth/                      # Auth Laravel Breeze
    │   │   │   ├── AdminDashboardController.php
    │   │   │   ├── HomeController.php
    │   │   │   ├── ProfileController.php
    │   │   │   ├── PublicController.php       # Direktori toko
    │   │   │   └── UserDashboardController.php
    │   │   │
    │   │   ├── Middleware/
    │   │   │   └── CheckRole.php              # Akses berbasis role
    │   │   │
    │   │   └── Requests/
    │   │       └── ProfileUpdateRequest.php
    │   │
    │   ├── Jobs/
    │   │   └── TranslateShopAttributes.php    # Terjemahan background
    │   │
    │   ├── Models/                # Model Eloquent
    │   │   ├── Content.php
    │   │   ├── Product.php
    │   │   ├── ProductImage.php
    │   │   ├── Region.php
    │   │   ├── Shop.php
    │   │   ├── ShopPhoto.php
    │   │   ├── Translation.php
    │   │   └── User.php
    │   │
    │   └── Services/
    │       ├── ImageService.php               # Integrasi Cloudinary
    │       └── TranslationService.php         # Terjemahan AI OpenRouter
    │
    ├── bootstrap/                # Bootstrap aplikasi
    │   ├── app.php
    │   └── cache/                # Cache framework
    │
    ├── config/                   # File konfigurasi
    │   ├── app.php
    │   ├── cloudinary.php         # Konfigurasi Cloudinary
    │   ├── database.php
    │   ├── services.php
    │   └── ...
    │
    ├── database/
    │   ├── migrations/           # Migrasi database (32 file)
    │   └── seeders/
    │       └── DatabaseSeeder.php
    │
    ├── lang/                     # Terjemahan (id, en)
    │   ├── en/
    │   └── id/
    │
    ├── public/                   # Document root web server
    │   ├── build/                # Aset terkompilasi (Vite)
    │   ├── images/               # Gambar statis
    │   ├── robots.txt            # File robots SEO
    │   ├── sitemap.xml           # Sitemap ter-generate
    │   └── index.php             # Entry point aplikasi
    │
    ├── resources/
    │   ├── css/
    │   │   └── app.css           # Tailwind CSS
    │   ├── js/
    │   │   ├── app.js
    │   │   └── bootstrap.js      # Inisialisasi Firebase Realtime Database
    │   └── views/                # Template Blade
    │       ├── admin/            # View panel admin
    │       ├── auth/             # View autentikasi (Breeze)
    │       ├── components/       # Komponen reusable
    │       ├── home/             # Homepage
    │       ├── umkm/             # Direktori toko publik
    │       └── users/            # Dashboard pengguna
    │
    ├── routes/
    │   ├── console.php           # Perintah Artisan
    │   └── web.php               # Route web
    │
    ├── storage/                  # Direktori storage (writable)
    │   ├── app/
    │   ├── framework/
    │   └── logs/
    │
    ├── tests/                    # Test PHPUnit
    │
    ├── .env.example              # Template environment
    ├── artisan                   # CLI Artisan
    ├── composer.json             # Dependencies PHP
    ├── package.json              # Dependencies NPM
    ├── vite.config.js            # Konfigurasi build Vite
    └── README.md                 # File ini
```

---

## API & Layanan Eksternal

### Cloudinary (CDN Gambar)

**Tujuan:** Penyimpanan dan pengiriman gambar berbasis cloud

**Konfigurasi:**

```env
CLOUDINARY_CLOUD_NAME=cloud_name_anda
CLOUDINARY_API_KEY=api_key_anda
CLOUDINARY_API_SECRET=api_secret_anda
```

**Penggunaan dalam Kode:**

```php
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;

// Upload gambar
$result = Cloudinary::upload($request->file('image')->getRealPath());
$url = $result->getSecurePath();

// Hapus gambar
Cloudinary::destroy($publicId);
```

**Fitur yang Digunakan:**

- Auto format (WebP)
- Optimasi kualitas otomatis
- Srcset responsif
- Transformasi on-the-fly

**Dokumentasi:** https://cloudinary.com/documentation/laravel_integration

---

### Firebase Realtime Database (Notifikasi Real-time)

**Tujuan:** Notifikasi real-time berbasis WebSocket

**Event yang Di-broadcast:**

- `ShopUpdated` - Perubahan status verifikasi toko
- `UserUpdated` - Update profil pengguna
- `ContentUpdated` - Perubahan konten CMS
- `ProductUpdated` - Modifikasi produk

**Penggunaan dalam Kode:**

```php
// Broadcasting event
use App\Events\ShopUpdated;

event(new ShopUpdated($shop));
```

```javascript
// Listening di frontend
window.Echo.channel("shop." + shopId).listen("ShopUpdated", (e) => {
  // Update UI
});
```

**Dokumentasi:** https://Firebase/docs/channels

---

### OpenRouter AI (Terjemahan)

**Tujuan:** Terjemahan bahasa bertenaga AI

**Konfigurasi:**

```env
OPENROUTER_API_KEY=sk-or-v1-api_key_anda
```

**Penggunaan dalam Kode:**

```php
use App\Services\TranslationService;

$translationService = new TranslationService();
$translated = $translationService->translate($text, 'en');
```

**Fitur:**

- Terjemahan Indonesia ke Inggris
- Terjemahan yang di-cache (database)
- Pemrosesan background job

**Dokumentasi:** https://openrouter.ai/docs

---

### Gmail SMTP (Email)

**Tujuan:** Verifikasi email dan notifikasi

**Konfigurasi:**

```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=email_anda@gmail.com
MAIL_PASSWORD=app_password_anda  # App Password!
```

**Setup:**

1. Aktifkan 2FA di Gmail
2. Generate App Password: https://myaccount.google.com/apppasswords
3. Gunakan App Password di `.env`

**Email yang Dikirim:**

- Verifikasi email
- Reset password
- Notifikasi verifikasi toko

**Dokumentasi:** https://support.google.com/accounts/answer/185833

---

### Firebase Realtime Database (Opsional)

**Tujuan:** Sinkronisasi data real-time opsional

**Konfigurasi:**

```env
FIREBASE_DATABASE_URL=https://your-project.firebaseio.com
```

**Catatan:** Saat ini opsional dan tidak diperlukan untuk fungsionalitas inti.

---

## Pemecahan Masalah

### Masalah Umum

#### 1. **Gambar tidak terupload / error Cloudinary**

**Gejala:**

- Tombol upload tidak berfungsi
- Error: "Cloudinary credentials not configured"

**Solusi:**

```bash
# Cek .env memiliki kredensial Cloudinary
grep CLOUDINARY .env

# Clear cache konfigurasi
php artisan config:clear
php artisan config:cache

# Test koneksi Cloudinary
php artisan tinker
> Cloudinary::upload('/path/to/test-image.jpg');
```

---

#### 2. **Gap auto-increment setelah penghapusan**

**Gejala:**

- ID loncat (misal, 1, 2, 10, 15)
- ID yang dihapus tidak digunakan ulang

**Solusi:**

```bash
# Reset counter auto-increment
php artisan db:reset-autoincrement

# Preview perubahan dulu
php artisan db:reset-autoincrement --dry-run

# Reset tabel spesifik
php artisan db:reset-autoincrement --table=shops
```

---

#### 3. **Job queue tidak diproses**

**Gejala:**

- Job terjemahan macet
- Tabel jobs membesar

**Solusi:**

```bash
# Cek tabel jobs
php artisan queue:failed

# Mulai queue worker
php artisan queue:work

# Retry job yang gagal
php artisan queue:retry all

# Untuk shared hosting, tambahkan cronjob:
*/5 * * * * cd /path/to/app && php artisan queue:work --stop-when-empty
```

---

#### 4. **Verifikasi email tidak terkirim**

**Gejala:**

- Tidak ada email diterima
- Email macet di queue

**Solusi:**

```bash
# Cek konfigurasi mail
grep MAIL .env

# Test pengiriman email
php artisan tinker
> Mail::raw('Test', function($msg) { $msg->to('test@example.com')->subject('Test'); });

# Cek log
tail -f storage/logs/laravel.log

# Untuk Gmail: Gunakan App Password, bukan password biasa
```

---

#### 5. **Notifikasi Firebase Realtime Database tidak berfungsi**

**Gejala:**

- Tidak ada update real-time
- Error console: "Firebase Realtime Database connection failed"

**Solusi:**

```bash
# Rebuild aset frontend
npm run build

# Cek console browser untuk error

# Verifikasi app Firebase Realtime Database aktif di dashboard Firebase
```

---

#### 6. **Error 404 di shared hosting**

**Gejala:**

- Homepage berfungsi, halaman lain tampil 404
- `.htaccess` tidak berfungsi

**Solusi:**

```bash
# Pastikan document root mengarah ke /public
# Di cPanel: Domains → domain → Document Root: /public_html/public

# Cek .htaccess ada di /public
cat public/.htaccess

# Aktifkan mod_rewrite (hubungi support hosting jika nonaktif)

# Clear cache route
php artisan route:clear
php artisan route:cache
```

---

#### 7. **Error permission denied**

**Gejala:**

- "Permission denied" saat menulis log
- "Failed to create directory"

**Solusi:**

```bash
# Perbaiki permissions
chmod -R 755 storage bootstrap/cache
chmod -R 775 storage/logs

# Perbaiki ownership (hanya SSH)
chown -R yourusername:yourusername storage bootstrap/cache
```

---

#### 8. **Koneksi database ditolak**

**Gejala:**

- "Connection refused"
- "SQLSTATE[HY000] [2002]"

**Solusi:**

```bash
# Cek kredensial database di .env
grep DB_ .env

# Verifikasi database ada
mysql -u username -p
> SHOW DATABASES;

# Cek MySQL berjalan
service mysql status  # VPS
# Hubungi support hosting untuk shared hosting

# Clear cache konfigurasi
php artisan config:clear
```

---

#### 9. **Sitemap tidak ter-generate**

**Gejala:**

- `/sitemap.xml` mengembalikan 404
- Perintah gagal diam-diam

**Solusi:**

```bash
# Jalankan pembuatan sitemap manual
php artisan sitemap:generate

# Cek permissions di /public
chmod 755 public

# Verifikasi toko ada
php artisan tinker
> Shop::where('is_verified', true)->count();

# Cek log
tail -f storage/logs/laravel.log
```

---

#### 10. **Terjemahan tidak berfungsi**

**Gejala:**

- Deskripsi toko tidak diterjemahkan
- Error API OpenRouter

**Solusi:**

```bash
# Cek API key
grep OPENROUTER_API_KEY .env

# Test terjemahan
php artisan tinker
> $service = new App\Services\TranslationService();
> $service->translate('Test teks', 'en');

# Cek kredit OpenRouter di openrouter.ai

# Trigger job terjemahan manual
php artisan tinker
> dispatch(new App\Jobs\TranslateShopAttributes($shop));
```

---

### Mendapatkan Bantuan

Jika masalah berlanjut:

1. **Cek log Laravel:**

   ```bash
   tail -f storage/logs/laravel.log
   ```

2. **Aktifkan mode debug sementara:**

   ```env
   APP_DEBUG=true  # file .env
   ```

   **Ingat untuk menonaktifkan setelah debugging!**

3. **Cek kebutuhan server:**

   ```bash
   php -v  # Harus >= 8.2
   php -m  # Cek ekstensi
   composer diagnose
   ```

4. **Informasi Kontak:**
   - Repository Proyek: [URL GitHub Anda]
   - Dokumentasi Laravel: https://laravel.com/docs
   - Stack Overflow: Tag pertanyaan dengan `laravel` dan `umkm-sasuma`

---

## Lisensi

Proyek ini dilisensikan di bawah MIT License.

---

## Kredit

**Dikembangkan oleh:** [Nama/Tim Anda]

**Dibangun dengan:**

- Laravel Framework - https://laravel.com
- Tailwind CSS - https://tailwindcss.com
- Alpine.js - https://alpinejs.dev
- Cloudinary - https://cloudinary.com
- Firebase Realtime Database - https://Firebase
- OpenRouter AI - https://openrouter.ai

---

## Dukungan

Untuk dukungan deployment atau pertanyaan:

- **Email:** [your-email@example.com]
- **Dokumentasi:** README.md ini
- **Issues:** [URL GitHub Issues Anda]

---

**Terakhir Diupdate:** 03 Februari 2026

**Versi:** 1.1.0
