
# Portofolio Web — CMS Dinamis

[![PHP](https://img.shields.io/badge/PHP-8.3+-777BB4?logo=php&logoColor=white)](https://php.net)
[![Laravel](https://img.shields.io/badge/Laravel-13-FF2D20?logo=laravel&logoColor=white)](https://laravel.com)
[![Vue](https://img.shields.io/badge/Vue-3.5-4FC08D?logo=vue.js&logoColor=white)](https://vuejs.org)
[![TypeScript](https://img.shields.io/badge/TypeScript-5.2-3178C6?logo=typescript&logoColor=white)](https://www.typescriptlang.org)
[![Tailwind CSS](https://img.shields.io/badge/Tailwind-4-06B6D4?logo=tailwindcss&logoColor=white)](https://tailwindcss.com)
[![Inertia](https://img.shields.io/badge/Inertia-3-9553E9?logo=inertia&logoColor=white)](https://inertiajs.com)

**Portofolio Web Dinamis Berbasis CMS** — Aplikasi web portofolio pribadi yang dilengkapi dengan *Content Management System* (CMS) pada panel admin. Admin dapat mengelola seluruh konten secara *real-time* melalui dashboard, sementara pengunjung dapat melihat profil, pengalaman, dan karya terbaru pada halaman publik.

---

## Daftar Isi

- [Latar Belakang dan Tujuan](#latar-belakang-dan-tujuan)
- [Fitur Utama](#fitur-utama)
- [Teknologi yang Digunakan](#teknologi-yang-digunakan)
- [Arsitektur Sistem](#arsitektur-sistem)
- [Instalasi dan Menjalankan Proyek](#instalasi-dan-menjalankan-proyek)
- [Struktur Folder](#struktur-folder)
- [Penggunaan Sistem](#penggunaan-sistem)
- [Route / Endpoint](#route--endpoint)

---

## Latar Belakang dan Tujuan

### Permasalahan

Banyak portofolio website bersifat *statis* — setiap perubahan konten (seperti menambahkan proyek baru, memperbarui pengalaman, atau mengganti foto profil) harus dilakukan dengan mengedit kode secara manual. Hal ini merepotkan bagi pemilik portofolio yang tidak memiliki latar belakang teknis.

### Tujuan

Membangun sebuah **sistem portofolio dinamis berbasis CMS** yang memungkinkan pemilik (admin) untuk mengelola seluruh konten website secara mandiri melalui antarmuka admin yang intuitif, tanpa perlu menyentuh kode.

### Manfaat

- **Real-time update** — perubahan konten langsung tampil di halaman publik
- **Tanpa coding** — kelola portofolio melalui form dan dashboard visual
- **Modern & responsif** — tampilan profesional di semua perangkat
- **Keamanan terpadu** — autentikasi dengan dukungan *two-factor authentication* (2FA) dan *passkeys* (WebAuthn)

---

## Fitur Utama

### Halaman Publik (Front-End)

| Fitur | Deskripsi |
|-------|-----------|
| **Hero Section** | Nama lengkap, profesi, foto profil, dan tombol Download CV / Hubungi Saya |
| **Tentang Saya** | Paragraf bio singkat tentang pemilik portofolio |
| **Timeline Pendidikan** | Riwayat pendidikan dalam tampilan kronologis |
| **Timeline Pengalaman** | Pengalaman organisasi, magang, dan kerja |
| **Galeri Portofolio** | Grid kartu proyek dengan thumbnail dan deskripsi singkat |
| **Detail Proyek (Modal)** | Deskripsi lengkap, teknologi yang digunakan, tautan eksternal |
| **Footer & Kontak** | Ikon media sosial aktif (LinkedIn, GitHub, Email, Instagram, Twitter/X) |
| **Dark/Light Mode** | Toggle tema gelap dan terang |
| **Animasi Scroll** | Efek *reveal* animasi saat scroll |

### Panel Admin (Back-End / CMS)

| Fitur | Deskripsi |
|-------|-----------|
| **Autentikasi** | Login via email/username + password, 2FA (TOTP), dan Passkeys (WebAuthn) |
| **Dashboard** | Ringkasan jumlah proyek, pengalaman, pendidikan, dan kontak |
| **Manajemen Identitas** | Update nama, profesi, bio, foto profil, dan upload CV |
| **Manajemen Pendidikan** | CRUD data pendidikan (institusi, gelar, tahun) |
| **Manajemen Pengalaman** | CRUD data pengalaman (kategori, posisi, instansi, tanggal) |
| **Manajemen Portofolio** | CRUD proyek (judul, thumbnail, deskripsi, link, tools) |
| **Manajemen Kontak** | CRUD tautan kontak & media sosial |
| **Pengaturan Profil** | Update profil admin (nama, email, foto) |
| **Pengaturan Keamanan** | Ubah password, kelola 2FA, kelola Passkeys |
| **Pengaturan Tampilan** | Pilih tema (Light / Dark / System) |

---

## Teknologi yang Digunakan

### Backend

| Teknologi | Kegunaan |
|-----------|----------|
| **PHP ^8.3** | Bahasa pemrograman server-side |
| **Laravel 13** | Framework PHP utama |
| **Laravel Fortify** | Backend autentikasi (login, 2FA, passkeys, registrasi) |
| **Inertia.js** | Perantara backend-frontend (monolit SPA tanpa REST API) |
| **Laravel Wayfinder** | Route generator type-safe untuk frontend |

### Frontend

| Teknologi | Kegunaan |
|-----------|----------|
| **Vue 3** (Composition API + `<script setup>`) | Framework frontend reaktif |
| **TypeScript** | Type-safe JavaScript |
| **Inertia.js Vue3 Adapter** | SPA routing tanpa API terpisah |
| **Tailwind CSS v4** | Utility-first CSS framework |
| **shadcn-vue** (New York v4) | Komponen UI siap pakai |
| **Reka UI** | *Headless* UI primitives |
| **Lucide Icons** | Library ikon |
| **Vue Sonner** | Notifikasi *toast* |
| **VueUse** | Koleksi komposabel Vue |

### Database

| Teknologi | Kegunaan |
|-----------|----------|
| **SQLite** *(default)* | Database ringan untuk pengembangan lokal |
| **MySQL / PostgreSQL** *(opsional)* | Dapat dialihkan untuk produksi |

### DevOps & Tooling

| Teknologi | Kegunaan |
|-----------|----------|
| **Vite 8** | Build tool frontend (HMR cepat) |
| **pnpm / npm** | Manajer paket Node.js |
| **Composer** | Manajer paket PHP |
| **Laravel Sail** | Lingkungan Docker |
| **GitHub Actions** | CI/CD (testing & linting otomatis) |
| **Dependabot** | Pembaruan dependensi otomatis |
| **ESLint + Prettier** | Linting & formatting frontend |
| **Laravel Pint** | PHP code style fixer |
| **PHPStan** (Level 7) | Static analysis PHP |
| **PHPUnit** | Testing framework |

---

## Arsitektur Sistem

Aplikasi ini menggunakan arsitektur **Monolitik SPA** (*Single Page Application*) di mana backend (Laravel) dan frontend (Vue 3) menyatu dalam satu *codebase* melalui **Inertia.js**.

```
┌─────────────────────────────────────────────────────┐
│                   Browser                           │
│  ┌──────────────────────────────────────────────┐   │
│  │         Vue 3 SPA (Inertia.js)               │   │
│  │  ┌─────────┐ ┌──────────┐ ┌──────────────┐  │   │
│  │  │  Pages   │ │Components│ │  Composables  │  │   │
│  │  └────┬────┘ └──────────┘ └──────────────┘  │   │
│  └───────┼──────────────────────────────────────┘   │
└──────────┼──────────────────────────────────────────┘
           │ Inertia (JSON + HTML over HTTP)
┌──────────┼──────────────────────────────────────────┐
│  Laravel │ (PHP 8.3+)                               │
│  ┌───────┴──────┐ ┌──────────┐ ┌────────────────┐   │
│  │  Controllers  │ │ Fortify  │ │  Middleware     │   │
│  └───────┬──────┘ └──────────┘ └────────────────┘   │
│          │                                           │
│  ┌───────┴──────┐ ┌──────────┐                      │
│  │    Models     │ │  Views   │                      │
│  └───────┬──────┘ └──────────┘                      │
│          │                                           │
│  ┌───────┴──────┐                                   │
│  │   Database   │ (SQLite / MySQL / PostgreSQL)      │
│  └──────────────┘                                   │
└─────────────────────────────────────────────────────┘
```

### Alur Data

1. **Pengunjung** membuka URL → `PublicController` mengambil data dari database → data dikirim ke `Welcome.vue` via Inertia → Vue me-render halaman publik
2. **Admin** login → Fortify memvalidasi kredensial (dengan opsi 2FA/Passkey) → redirect ke `/dashboard`
3. **Admin** melakukan CRUD → Controller memvalidasi dan menyimpan ke database → Inertia mengembalikan response + flash toast → halaman diperbarui secara reaktif

---

## Instalasi dan Menjalankan Proyek

### Prasyarat

- **PHP** ^8.3 ([unduh](https://php.net/downloads))
- **Composer** ([unduh](https://getcomposer.org))
- **Node.js** ^18 / ^20 / ^22 ([unduh](https://nodejs.org))
- **pnpm** atau **npm**

### Langkah Instalasi

```bash
# 1. Clone repository
git clone https://github.com/username/portofolio-web.git
cd portofolio-web

# 2. Setup otomatis (install dependency + generate key + migrate + build)
composer setup
```

Atau secara manual:

```bash
# 2a. Install dependensi PHP
composer install

# 2b. Buat file environment
copy .env.example .env

# 2c. Generate application key
php artisan key:generate

# 2d. Edit file .env sesuai kebutuhan (database, mail, dll.)
#     Default: DB_CONNECTION=sqlite (sudah siap pakai)

# 2e. Jalankan migrasi database
php artisan migrate

# 2f. (Opsional) Seed admin user
php artisan db:seed

# 2g. Install dependensi frontend
npm install
# atau: pnpm install

# 2h. Build aset frontend
npm run build

# 2i. Buat symlink storage
php artisan storage:link
```

### Menjalankan Server (Development)

```bash
# Semua service sekaligus (server + queue + logs + Vite HMR)
composer dev
```

Atau secara manual:

```bash
# Terminal 1: Laravel dev server
php artisan serve --host=localhost

# Terminal 2: Vite HMR
npm run dev

# Terminal 3: Queue worker (jika diperlukan)
php artisan queue:listen --tries=1 --timeout=0

# Terminal 4: Log viewer (opsional)
php artisan pail --timeout=0
```

Akses aplikasi di **http://localhost:8000**

### Menjalankan untuk Produksi

```bash
# Build aset untuk production
npm run build

# Pastikan .env telah dikonfigurasi untuk production
# (DB, MAIL, APP_URL, APP_ENV=production, APP_DEBUG=false)

# Optimasi Laravel
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

### Menjalankan Quality Checks

```bash
# Full CI check (lint + format + type + test)
composer ci:check

# Perintah terpisah:
composer lint          # Perbaiki style PHP (Pint)
npm run lint           # Perbaiki style frontend (ESLint)
npm run format         # Format frontend (Prettier)
npm run types:check    # Type check frontend (vue-tsc)
composer types:check   # Static analysis PHP (PHPStan)
composer test          # Jalankan test (PHPUnit)
```

---

## Struktur Folder

```
├── .env.example              # Template environment
├── .github/
│   ├── dependabot.yml        # Auto-update dependensi
│   └── workflows/            # GitHub Actions CI/CD
├── app/                      # Kode backend (Laravel)
│   ├── Actions/Fortify/      # Fortify actions
│   ├── Concerns/             # Validation rules traits
│   ├── Http/
│   │   ├── Controllers/      # Controllers (Public, CRUD, Settings)
│   │   ├── Middleware/       # HandleAppearance, HandleInertiaRequests
│   │   └── Requests/         # Form request validation
│   ├── Models/               # Eloquent Models
│   └── Providers/            # Service Providers
├── bootstrap/                # Laravel bootstrap
├── config/                   # Konfigurasi Laravel
├── database/
│   ├── migrations/           # Migrasi database (7 tabel)
│   ├── seeders/              # Database seeder
│   └── database.sqlite       # Database SQLite (default)
├── public/                   # Entry point & aset publik
│   └── storage/              # Symlink ke storage/app/public
├── resources/
│   ├── css/app.css           # Tailwind CSS v4
│   ├── js/                   # Frontend (Vue 3 + TypeScript)
│   │   ├── app.ts            # Inertia app entry
│   │   ├── components/       # Vue components
│   │   │   └── ui/           # shadcn-vue UI components
│   │   ├── composables/      # Vue composables (useAppearance, dll)
│   │   ├── layouts/          # Layout pages (App, Auth, Settings)
│   │   ├── lib/              # Utilities (cn, flashToast)
│   │   ├── pages/            # Halaman Inertia (Welcome, Dashboard, dll)
│   │   └── types/            # TypeScript type definitions
│   └── views/app.blade.php   # Root Blade template
├── routes/
│   ├── web.php               # Route utama (public + admin CRUD)
│   └── settings.php          # Route pengaturan (profile, security, appearance)
├── storage/                  # File uploads, logs, cache
├── summary.md                # Software Requirements Specification (SRS)
├── tests/                    # PHPUnit tests
├── composer.json
├── package.json
├── vite.config.ts
└── tsconfig.json
```

---

## Penggunaan Sistem

### Hak Akses

| Aktor | Deskripsi | Akses |
|-------|-----------|-------|
| **Pengunjung** | Siapa saja yang membuka URL website | Melihat halaman publik (/) |
| **Admin** | Pemilik portofolio (terautentikasi) | Dashboard + seluruh fitur CRUD + pengaturan |

### Cara Login Admin

1. Buka **http://localhost:8000/dashboard** (akan redirect ke halaman login jika belum login)
2. Masukkan **Username** (`admin`) atau **Email** (`admin@example.com`) dan **Password** (`satya_2004`)
3. Klik **Sign in**
4. Setelah login, Anda akan masuk ke **Dashboard Admin**

### Mengakses Fitur CMS

Setelah login, panel navigasi sidebar menyediakan akses ke:

| Menu | Fungsi |
|------|--------|
| **Dashboard** | Ringkasan statistik konten |
| **Identitas** | Edit data diri (nama, profesi, bio, foto profil, CV) |
| **Pendidikan** | Kelola riwayat pendidikan (Tambah / Edit / Hapus) |
| **Pengalaman** | Kelola riwayat pengalaman (Organisasi / Magang / Kerja) |
| **Portofolio** | Kelola proyek portofolio |
| **Kontak** | Kelola tautan media sosial & kontak |
| **Settings > Profile** | Update profil admin (nama, email, foto) |
| **Settings > Security** | Ubah password, aktifkan 2FA, kelola Passkeys |
| **Settings > Appearance** | Pilih tema Light / Dark / System |

### Mengelola Portofolio (Contoh)

1. Buka menu **Portofolio** di sidebar
2. Klik **Tambah Proyek**
3. Isi form: judul, upload thumbnail, deskripsi singkat & lengkap, link eksternal, tools
4. Klik **Simpan** — proyek langsung tampil di halaman publik
5. Untuk mengedit: klik ikon edit pada baris proyek
6. Untuk menghapus: klik ikon hapus

### Halaman Publik

Halaman publik diakses melalui **/** (root URL). Pengunjung dapat:

- Melihat hero section dengan nama, profesi, dan foto profil
- Membaca bagian "Tentang Saya"
- Scroll timeline pendidikan dan pengalaman
- Menjelajahi galeri proyek portofolio
- Klik proyek untuk melihat detail lengkap (modal)
- Mengakses tautan kontak/media sosial di footer

---

## Route / Endpoint

### Publik (Tanpa Autentikasi)

| Method | URI | Controller | Deskripsi |
|--------|-----|------------|-----------|
| GET | `/` | `PublicController@index` | Halaman publik portofolio |

### Autentikasi (Laravel Fortify)

Fortify menyediakan endpoint secara otomatis (login, register, logout, password reset, email verification, 2FA, passkeys).

### Admin CRUD (Auth + Verified)

| Method | URI | Deskripsi |
|--------|-----|-----------|
| GET | `/dashboard` | Dashboard admin |
| GET | `/settings/identitas` | Form edit identitas |
| POST | `/identitas` | Update identitas |
| GET | `/settings/pendidikan` | Daftar pendidikan |
| POST | `/pendidikan` | Tambah pendidikan |
| PUT | `/pendidikan/{id}` | Edit pendidikan |
| DELETE | `/pendidikan/{id}` | Hapus pendidikan |
| GET | `/settings/pengalaman` | Daftar pengalaman |
| POST | `/pengalaman` | Tambah pengalaman |
| PUT | `/pengalaman/{id}` | Edit pengalaman |
| DELETE | `/pengalaman/{id}` | Hapus pengalaman |
| GET | `/settings/portofolio` | Daftar portofolio |
| POST | `/portofolio` | Tambah proyek |
| POST | `/portofolio/{id}` | Edit proyek |
| DELETE | `/portofolio/{id}` | Hapus proyek |
| GET | `/settings/kontak` | Daftar kontak |
| POST | `/kontak` | Tambah kontak |
| PUT | `/kontak/{id}` | Edit kontak |
| DELETE | `/kontak/{id}` | Hapus kontak |

### Settings (Auth)

| Method | URI | Deskripsi |
|--------|-----|-----------|
| GET | `/settings/profile` | Form edit profil admin |
| PATCH | `/settings/profile` | Update profil admin |
| DELETE | `/settings/profile` | Hapus akun admin |
| GET | `/settings/security` | Pengaturan keamanan |
| PUT | `/settings/password` | Ubah password |
| GET | `/settings/appearance` | Pengaturan tema |
| GET | `/.well-known/passkey-endpoints` | Endpoint Passkeys (WebAuthn) |

---

## Lisensi

Proyek ini menggunakan lisensi **MIT**.
