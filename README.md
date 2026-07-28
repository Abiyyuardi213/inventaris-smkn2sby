<p align="center">
  <img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="300" alt="Laravel Logo">
</p>

<h1 align="center">Sistem Inventaris Sarana Prasarana</h1>
<h3 align="center">SMKN 2 Surabaya</h3>

<p align="center">
  <img src="https://img.shields.io/badge/Laravel-13.x-red?logo=laravel" alt="Laravel Version">
  <img src="https://img.shields.io/badge/PHP-8.3+-blue?logo=php" alt="PHP Version">
  <img src="https://img.shields.io/badge/License-MIT-green" alt="License">
</p>

---

## 📋 Tentang Proyek

**Sistem Inventaris Sarana Prasarana SMKN 2 Surabaya** adalah aplikasi web berbasis Laravel yang dirancang untuk mengelola seluruh aset dan barang inventaris sekolah secara terpusat, efisien, dan terstruktur.

Sistem ini memudahkan pengelolaan aset mulai dari pencatatan barang, pengadaan, peminjaman, mutasi ruangan, hingga cetak laporan — semuanya dalam satu platform yang terintegrasi.

---

## ✨ Fitur Utama

### 📦 Manajemen Inventaris
- Pencatatan data barang lengkap: nama, merek, tipe, spesifikasi, kondisi, warna, bahan, sumber dana
- Kode inventaris unik per barang
- Upload foto barang
- Generate & cetak **QR Code** label per barang
- Cetak label QR secara massal (bulk)
- Scan QR Code untuk melihat detail barang secara cepat
- **Import** data dari file Excel (`.xlsx`) menggunakan sistem batch approval
- **Export** data ke file Excel (`.xlsx`)
- Cetak laporan inventaris dalam format **PDF**
- Hapus barang terpilih atau hapus seluruh barang

### 🏫 Manajemen Ruangan & Unit Kerja
- Pengelolaan data ruangan per unit kerja / jurusan
- Pemantauan aset per ruangan (*Monitor Ruang*)
- Cetak **Kartu Inventaris Ruang** (KIR) dalam format PDF

### 🔄 Pengadaan & Mutasi
- Pengajuan pengadaan barang baru
- Alur persetujuan pengadaan (*approval* oleh Admin Utama & Kepala Sekolah)
- Mutasi barang antar ruangan dengan pencatatan nomor surat dan penanggung jawab

### 📤 Peminjaman Eksternal
- Pencatatan peminjaman barang oleh pihak luar
- Monitoring status peminjaman dan tanggal estimasi kembali
- Notifikasi informasi kontak peminjam

### 👥 Manajemen Pengguna & Akses
- Sistem autentikasi login
- Manajemen **Role & Permission** berbasis granular
- Pengelolaan akun pengguna
- Profil pengguna

### 📊 Dashboard
- Ringkasan statistik aset: total barang, kondisi, nilai inventaris
- Overview pengadaan, peminjaman, dan mutasi terkini

---

## 🛠️ Teknologi yang Digunakan

| Komponen | Teknologi |
|---|---|
| Backend Framework | [Laravel 13](https://laravel.com) |
| Bahasa | PHP 8.3+ |
| Database | MySQL |
| Frontend Styling | Tailwind CSS |
| Build Tool | Vite |
| QR Code | [simplesoftwareio/simple-qrcode](https://www.simplesoftware.io/docs/simple-qrcode) |
| Excel Import/Export | PhpSpreadsheet |
| Testing | PHPUnit |

---

## ⚙️ Persyaratan Sistem

- PHP >= 8.3
- Composer
- Node.js & NPM
- MySQL
- Ekstensi PHP: `pdo`, `mbstring`, `xml`, `zip`, `gd`

---

## 🚀 Instalasi

### 1. Clone Repositori

```bash
git clone https://github.com/Abiyyuardi213/inventaris-smkn2sby.git
cd inventaris-smkn2sby
```

### 2. Install Dependensi

```bash
composer install
npm install
```

### 3. Konfigurasi Environment

```bash
cp .env.example .env
php artisan key:generate
```

Atur koneksi database di file `.env`:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=db_inventaris_smkn2sby
DB_USERNAME=root
DB_PASSWORD=
```

### 4. Migrasi & Seed Database

```bash
php artisan migrate
php artisan db:seed
```

### 5. Build Asset Frontend

```bash
npm run build
```

### 6. Jalankan Server

```bash
php artisan serve
```

Atau gunakan script `dev` untuk menjalankan semua layanan sekaligus (server, queue, log watcher, Vite):

```bash
composer dev
```

Akses aplikasi di: **http://127.0.0.1:8000**

---

## 👤 Akun Default

Setelah seeding, akun default tersedia:

| Role | Email | Password |
|---|---|---|
| Admin Utama | `adminutama@example.com` | `password` |
| Operator | `operator@example.com` | `password` |
| Kepala Sekolah | `kepsek@example.com` | `password` |

> ⚠️ Segera ubah password setelah login pertama kali.

---

## 🧪 Menjalankan Test

```bash
php artisan test
# atau
vendor/bin/phpunit
```

---

## 📁 Struktur Modul Utama

```
app/
├── Http/Controllers/
│   ├── InventarisController.php       # Manajemen barang inventaris
│   ├── InventarisImportController.php # Import/Export Excel & template
│   ├── PengadaanController.php        # Pengadaan barang
│   ├── MutasiController.php           # Mutasi barang antar ruangan
│   ├── PeminjamanController.php       # Peminjaman eksternal
│   ├── RuanganController.php          # Manajemen ruangan & KIR
│   ├── JurusanController.php          # Unit kerja / jurusan
│   ├── JenisModalController.php       # Jenis modal (kategori aset)
│   ├── ApprovalController.php         # Alur persetujuan pengadaan
│   ├── ApprovalKepsekController.php   # Persetujuan kepala sekolah
│   ├── DashboardController.php        # Statistik & ringkasan
│   ├── RoleController.php             # Manajemen role & permission
│   └── UserController.php             # Manajemen pengguna
```

---

## 📝 Lisensi

Proyek ini dikembangkan untuk keperluan internal **SMKN 2 Surabaya** dan dilisensikan di bawah [MIT License](https://opensource.org/licenses/MIT).

---

<p align="center">Dikembangkan dengan ❤️ untuk SMKN 2 Surabaya</p>
