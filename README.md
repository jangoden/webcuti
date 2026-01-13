# Web Cuti - Sistem Informasi Manajemen Cuti Pegawai

Aplikasi manajemen cuti pegawai berbasis web modern yang dibangun menggunakan **Laravel 12**, **Filament v4**, dan **Livewire 3**. Aplikasi ini memudahkan pegawai untuk mengajukan cuti dan memudahkan admin/HRD untuk mengelola persetujuan serta rekapitulasi laporan.

## 🚀 Teknologi Utama

-   **Framework:** Laravel 12
-   **Admin Panel:** FilamentPHP v4
-   **Frontend:** Livewire 3 & Blade
-   **Styling:** Tailwind CSS v4
-   **Database:** MySQL / MariaDB
-   **PDF Export:** Barryvdh DomPDF

---

## 📋 Prasyarat Sistem (Requirements)

Sebelum memulai, pastikan komputer Anda sudah terinstall aplikasi berikut:

1.  **PHP** versi 8.2 atau lebih baru.
2.  **Composer** (Dependency Manager untuk PHP).
3.  **Node.js** & **NPM** (Untuk compile aset Tailwind CSS).
4.  **MySQL** (Bisa via Laragon, XAMPP, atau Docker).
5.  **Git** (Opsional, untuk clone repository).

---

## 🛠️ Panduan Instalasi (Step-by-Step)

Ikuti langkah-langkah ini secara berurutan. Jangan ada yang terlewat.

### 1. Clone atau Download Project
Buka terminal (Command Prompt/PowerShell/Git Bash) dan arahkan ke folder di mana Anda ingin menyimpan project.

```bash
git clone https://github.com/username/webcuti.git
cd webcuti
```
*(Jika Anda tidak menggunakan git, cukup ekstrak file zip project ini dan masuk ke foldernya via terminal).*

### 2. Install Dependensi PHP (Backend)
Jalankan perintah ini untuk mengunduh semua library Laravel yang dibutuhkan:

```bash
composer install
```

### 3. Install Dependensi JavaScript (Frontend)
Jalankan perintah ini untuk mengunduh library Tailwind dan aset lainnya:

```bash
npm install
```

### 4. Konfigurasi Environment (.env)
Salin file konfigurasi contoh menjadi file konfigurasi aktif:

```bash
cp .env.example .env
```

Buka file `.env` tersebut menggunakan Text Editor (Notepad, VS Code, dll). Cari bagian Database dan sesuaikan dengan settingan database lokal Anda (biasanya di Laragon/XAMPP user-nya `root` dan password kosong).

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=webcuti
DB_USERNAME=root
DB_PASSWORD=
```

### 5. Generate Application Key
Kunci enkripsi aplikasi harus dibuat agar session dan keamanan berjalan lancar:

```bash
php artisan key:generate
```

### 6. Buat Database
Pastikan Anda sudah membuat database kosong bernama `webcuti` di MySQL Anda (bisa lewat phpMyAdmin atau HeidiSQL).
Jika menggunakan terminal MySQL:
```sql
CREATE DATABASE webcuti;
```

### 7. Migrasi Database & Seeding (PENTING!)
Langkah ini akan membuat tabel-tabel di database dan mengisi data awal (seperti akun Admin default).

```bash
php artisan migrate --seed
```
*Tunggu hingga proses selesai. Ini akan membuat tabel users, leave_requests, leave_types, dll.*

### 8. Link Storage (Opsional)
Agar file upload (seperti foto profil/lampiran) bisa diakses publik:

```bash
php artisan storage:link
```

---

## 🏃‍♂️ Cara Menjalankan Aplikasi

Anda perlu menjalankan **dua** terminal secara bersamaan agar aplikasi berjalan sempurna (karena menggunakan Vite untuk asetnya).

**Terminal 1 (Server Laravel):**
```bash
php artisan serve
```
*Aplikasi akan berjalan di: http://127.0.0.1:8000*

**Terminal 2 (Vite Build/Dev):**
```bash
npm run dev
```
*Biarkan terminal ini terbuka selama Anda mengembangkan aplikasi agar perubahan CSS langsung terlihat.*

---

## 🔑 Akun Login Default

Setelah menjalankan `php artisan migrate --seed`, sistem akan membuatkan akun default berikut:

### 1. Administrator (Akses Panel Admin)
-   **URL:** [http://127.0.0.1:8000/admin/login](http://127.0.0.1:8000/admin/login)
-   **Email:** `admin@webcuti.com`
-   **Password:** `password`

### 2. Pegawai (Akses Dashboard Pegawai)
-   **URL:** [http://127.0.0.1:8000/login](http://127.0.0.1:8000/login)
-   **Email:** `budi@webcuti.com` (Contoh dari seeder)
-   **Password:** `password`

---

## 📚 Fitur Utama

### Panel Admin (Filament)
1.  **Dashboard:** Statistik realtime (Total pegawai, cuti pending, disetujui, dll).
2.  **Manajemen Pegawai:** Tambah, edit, hapus data pegawai (Role Admin tidak bisa dihapus).
3.  **Jenis Cuti:** Mengatur tipe cuti (Tahunan, Sakit, Melahirkan, dll) dan kuotanya.
4.  **Persetujuan Cuti:** Menerima atau menolak pengajuan cuti pegawai.
5.  **Rekap Cuti:** Laporan rekapitulasi dengan filter periode (Bulanan/Tahunan) dan **Export PDF**.

### Dashboard Pegawai
1.  **Pengajuan Cuti:** Form formulir pengajuan cuti baru.
2.  **Riwayat Cuti:** Melihat status pengajuan (Pending/Disetujui/Ditolak).
3.  **Sisa Cuti:** Informasi kuota cuti yang tersisa.
4.  **Profil:** Mengubah data diri dan password.

---

## ❓ Troubleshooting (Masalah Umum)

**Q: Tampilan berantakan / CSS tidak muncul?**
A: Pastikan Anda sudah menjalankan `npm run dev` di terminal. Atau jika di production, jalankan `npm run build`.

**Q: Error "Target class [hash] does not exist"?**
A: Hapus folder `bootstrap/cache/config.php` jika ada, lalu jalankan `php artisan config:clear`.

**Q: Error 403 Forbidden saat masuk Admin?**
A: Pastikan Anda login menggunakan akun dengan email `admin@...`. Jika Anda login sebagai pegawai biasa, Anda tidak berhak mengakses halaman admin. Silakan logout dulu.

**Q: Error 500 Server Error?**
A: Cek file `storage/logs/laravel.log` untuk detail error. Biasanya masalah koneksi database atau permission folder.

---

**Dibuat oleh:** Tim Pengembang Web Cuti
**Tahun:** 2026
