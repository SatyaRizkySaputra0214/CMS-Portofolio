Software Requirements Specification (SRS)

Website Portofolio Dinamis (CMS Based)

1. Pendahuluan

Sistem ini adalah sebuah aplikasi berbasis web yang berfungsi sebagai Website Portofolio Dinamis. Aplikasi ini terbagi menjadi dua bagian utama:

Front-End (Halaman Publik): Halaman yang dilihat oleh pengunjung/rekruter untuk melihat profil, pengalaman, dan karya pemilik portofolio.

Back-End (Panel Admin / CMS): Halaman khusus yang diamankan dengan login untuk pemilik portofolio (Admin) agar dapat menambah, mengubah, atau menghapus data konten web secara real-time.

Buatkan akun admin dengan username : admin, pass: satya_2004, jika ada yg mengakses halaman login admin, maka munculkan halaman login, namun jika tidak langsung munculkan halaman publik (default)

2. Aktor dan Hak Akses

Terdapat dua aktor utama yang berinteraksi dengan sistem ini:

Aktor

Deskripsi

Hak Akses

Admin

Pemilik portofolio yang mengelola konten website.

Melakukan Login/Logout, CRUD (Create, Read, Update, Delete) pada semua data (Identitas, Pendidikan, Pengalaman, Portofolio, Kontak), serta mengatur akun profilnya sendiri.

Pengunjung

Siapa saja yang mengakses URL website.

Melihat halaman beranda, membaca biodata, melihat riwayat pendidikan & pengalaman, melihat detail proyek portofolio, dan mengakses tautan kontak.

3. Ketentuan UI/UX (Desain Visual)

Desain antarmuka dirancang agar terlihat profesional, bersih (clean), dan berfokus pada konten (content-centric).

A. Skema Warna (Color Palette)

Menggunakan pendekatan warna profesional dengan kontras yang baik.

Warna Utama (Primary): #1E293B (Slate 800 - Biru Dongker Gelap) - Untuk header, footer, dan teks utama.

Warna Aksen (Accent): #3B82F6 (Blue 500) atau #0D9488 (Teal 600) - Untuk tombol, tautan aktif, dan hover effect.

Warna Latar Belakang (Background): * Primary BG: #F8FAFC (Slate 50 - Putih agak abu-abu).

Secondary/Section BG: #FFFFFF (Putih Murni).

Warna Teks (Text): #334155 (Slate 700) untuk paragraf, #0F172A (Slate 900) untuk judul/Heading.

B. Tipografi (Font)

Kombinasi font sans-serif untuk kesan modern dan mudah dibaca di berbagai perangkat (responsive).

Font Heading (H1 - H6): Montserrat atau Poppins (Bold/Semi-bold). Memberikan kesan tegas dan profesional.

Font Body (Paragraf, Teks Deskripsi): Inter atau Roboto (Regular/Medium). Sangat nyaman dibaca untuk teks panjang.

4. Fitur Utama Aplikasi

A. Halaman Publik (Front-End)

Hero Section: Menampilkan nama lengkap, profesi utama (misal: "Software Engineer"), foto profil, dan tombol "Download CV" / "Hubungi Saya".

Tentang Saya (About): Paragraf singkat mengenai identitas dasar dan value pemilik portofolio.

Timeline Pendidikan & Pengalaman: Menampilkan riwayat secara kronologis (bisa menggunakan desain visual garis waktu/timeline).

Galeri Portofolio: Menampilkan grid card daftar proyek. Setiap card berisi foto thumbnail, judul, dan deskripsi singkat.

Detail Portofolio (Modal/Halaman Baru): Saat proyek diklik, muncul detail lebih lengkap (deskripsi panjang, teknologi yang digunakan, tautan ke proyek/GitHub).

Footer & Kontak: Menampilkan ikon media sosial aktif, email, atau formulir kontak langsung.

B. Panel Admin (Back-End)

Otentikasi: Form Login menggunakan Username/Email dan Password.

Dashboard: Ringkasan jumlah proyek, pengalaman, dll.

Manajemen Identitas: Form tunggal untuk meng-update nama, bio, dan foto profil.

Manajemen Pendidikan: Tabel data pendidikan. Fitur: Tambah, Edit, Hapus (Institusi, Gelar, Tahun, Deskripsi).

Manajemen Pengalaman: Tabel data pengalaman. Fitur: Tambah, Edit, Hapus (Posisi, Perusahaan, Kategori 

$$Organisasi/Magang/Kerja$$

, Durasi, Deskripsi).

Manajemen Portofolio: Tabel data proyek. Fitur: Tambah, Edit, Hapus (Judul, Thumbnail 

$$Upload File$$

, Deskripsi Singkat, Detail Lengkap, Tautan Eksternal).

Manajemen Kontak: Menambah atau menghapus link (Misal: LinkedIn, Email, GitHub).

5. Alur Aplikasi (Flow)

A. Alur Pengunjung (Visitor Flow)

Pengunjung membuka domain website (misal: www.namakamu.com).

Sistem memuat data dari database (Identitas, Pengalaman, Portofolio terbaru) dan merendernya di halaman utama.

Pengunjung melakukan scroll atau menggunakan menu navigasi (Pendidikan, Portofolio, Kontak).

Pengunjung mengklik salah satu thumbnail proyek.

Sistem menampilkan detail proyek tersebut.

Pengunjung mengklik tombol/ikon media sosial di bagian bawah yang akan mengarahkan mereka ke URL tujuan (misal: halaman LinkedIn Anda).

B. Alur Admin (Admin Flow)

Admin mengakses URL khusus (misal: www.namakamu.com/admin).

Admin memasukkan kredensial login.

Sistem memvalidasi kredensial. Jika sukses, masuk ke Dashboard Admin.

Admin ingin menambah proyek baru:

Klik menu "Kelola Portofolio".

Klik tombol "Tambah Proyek Baru".

Isi form (Judul, Upload Gambar Thumbnail, Tulis Detail).

Klik "Simpan".

Sistem menyimpan gambar ke server dan menyimpan teks ke database.

Proyek baru secara otomatis langsung tampil di Halaman Publik.

6. Skema Database (MySQL)

Berikut adalah rancangan struktur database relasional menggunakan bahasa query SQL. Anda dapat menyalin query di bawah ini untuk membuat tabel secara otomatis di dalam database Anda.

Informasi Koneksi Database:

Nama Database : if0_42201773_portofolio

Username : if0_42201773

Password : G1nmxQUIAGpUtt

MySQL Hostname : sql105.infinityfree.com

MySQL Port : 3306

Query DDL (Data Definition Language):

-- Pilih database yang digunakan
USE if0_42201773_portofolio;

-- 1. Tabel users (Untuk login admin)
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL,
    password VARCHAR(255) NOT NULL COMMENT 'Harus di-hash dengan Bcrypt',
    email VARCHAR(100) NOT NULL
);

-- 2. Tabel identitas (Konfigurasi dasar)
CREATE TABLE identitas (
    id INT PRIMARY KEY DEFAULT 1,
    nama_lengkap VARCHAR(100) NOT NULL,
    profesi VARCHAR(100) NOT NULL,
    tentang_saya TEXT,
    foto_profil VARCHAR(255),
    cv_file VARCHAR(255)
);

-- 3. Tabel pendidikan
CREATE TABLE pendidikan (
    id INT AUTO_INCREMENT PRIMARY KEY,
    institusi VARCHAR(150) NOT NULL,
    gelar_jurusan VARCHAR(100) NOT NULL,
    tahun_mulai YEAR NOT NULL,
    tahun_selesai YEAR NULL COMMENT 'Bisa NULL jika masih studi',
    deskripsi TEXT
);

-- 4. Tabel pengalaman
CREATE TABLE pengalaman (
    id INT AUTO_INCREMENT PRIMARY KEY,
    kategori ENUM('Organisasi', 'Magang', 'Kerja') NOT NULL,
    posisi VARCHAR(100) NOT NULL,
    nama_instansi VARCHAR(150) NOT NULL,
    tanggal_mulai DATE NOT NULL,
    tanggal_selesai DATE NULL COMMENT 'NULL jika Present/Sekarang',
    deskripsi TEXT
);

-- 5. Tabel portofolio (Tabel Proyek)
CREATE TABLE portofolio (
    id INT AUTO_INCREMENT PRIMARY KEY,
    judul_proyek VARCHAR(150) NOT NULL,
    thumbnail VARCHAR(255),
    deskripsi_singkat VARCHAR(255) NOT NULL,
    deskripsi_lengkap TEXT,
    link_eksternal VARCHAR(255),
    dibuat_pada TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- 6. Tabel kontak
CREATE TABLE kontak (
    id INT AUTO_INCREMENT PRIMARY KEY,
    platform VARCHAR(50) NOT NULL COMMENT 'Contoh: LinkedIn, GitHub, Email',
    url VARCHAR(255) NOT NULL,
    ikon VARCHAR(100) COMMENT 'Class icon (misal: fa-brands fa-linkedin)'
);


Dokumen ini dapat digunakan sebagai acuan dasar bagi Programmer (Frontend & Backend) serta UI/UX Designer untuk memulai tahap pengembangan aplikasi.