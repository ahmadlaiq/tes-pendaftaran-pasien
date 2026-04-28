# Sistem Pendaftaran Pasien (Laravel)

Sistem pendaftaran pasien sederhana berbasis web dan RESTful API untuk klinik/puskesmas.

## Fitur Utama
- **Manajemen Pasien**: CRUD data pasien dengan validasi NIK (16 digit unik).
- **Pendaftaran Kunjungan**: Pendaftaran pasien ke poli tertentu dengan nomor antrian otomatis yang reset harian.
- **RESTful API**: Endpoint untuk manajemen pasien dan pendaftaran menggunakan Laravel Sanctum.
- **Dashboard**: Statistik total pasien, kunjungan hari ini, dan antrian aktif.
- **Laporan**: Filter daftar kunjungan dan fitur cetak PDF.
- **Bonus**: Unit/Feature testing untuk skenario kritikal.

## Tech Stack
- Laravel 12.x
- PHP 8.2+
- MySQL
- Tailwind CSS (via Laravel Breeze)
- Sanctum (API Auth)
- DomPDF (Laporan PDF)

## Instalasi

1. Clone repository ini.
2. Salin file `.env.example` menjadi `.env`.
   ```bash
   cp .env.example .env
   ```
3. Sesuaikan konfigurasi database di `.env`.
4. Install dependensi PHP:
   ```bash
   composer install
   ```
5. Generate application key:
   ```bash
   php artisan key:generate
   ```
6. Jalankan migrasi dan seeder:
   ```bash
   php artisan migrate --seed
   ```
7. Build aset frontend (opsional jika sudah ada build):
   ```bash
   npm install && npm run build
   ```
8. Jalankan server:
   ```bash
   php artisan serve
   ```

## Akun Demo
- **Email**: `admin@klinik.com`
- **Password**: `password`

## Dokumentasi API
Dokumentasi lengkap mengenai endpoint API, payload, dan response dapat dilihat pada file berikut:
[**documentation/README.md**](documentation/README.md)

## Pengujian (Testing)
Jalankan perintah berikut untuk mengeksekusi Feature Test:
```bash
php artisan test --filter RegistrationTest
```
