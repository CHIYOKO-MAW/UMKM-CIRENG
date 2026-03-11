# Panduan Menjalankan Project (Versi Mudah, Non-Programmer Friendly)

Dokumen ini ditulis untuk pengguna yang belum terbiasa dengan coding/web development.

## 1) Yang Perlu Disiapkan
Install aplikasi berikut terlebih dahulu:

- Git
- PHP 8.2 atau lebih baru
- Composer
- Node.js LTS (disarankan 18+)
- MySQL atau MariaDB
- Terminal (CMD/PowerShell/Terminal VSCode)

## 2) Ambil Source Code
Jika project belum ada di laptop:

```bash
git clone <URL_REPOSITORY_KAMU>
cd umkm-cireng
```

Jika project sudah ada, buka folder project-nya.

## 3) Buat Database
Buka MySQL lalu buat database baru, contoh:

- Nama database: `umkm_cireng`

## 4) Konfigurasi File `.env`
Copy file contoh konfigurasi:

```bash
cp .env.example .env
```

Kalau di Windows PowerShell:

```powershell
Copy-Item .env.example .env
```

Lalu edit file `.env` bagian database:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=umkm_cireng
DB_USERNAME=root
DB_PASSWORD=
```

Sesuaikan `DB_USERNAME` dan `DB_PASSWORD` dengan MySQL kamu.

## 5) Install Dependency
Jalankan perintah ini di folder project:

```bash
composer install
npm install
```

## 6) Generate Key + Migrasi + Seeder
```bash
php artisan key:generate
php artisan migrate --seed
php artisan storage:link
```

Seeder akan membuat:
- data produk
- data user demo (admin/customer)
- data riwayat pesanan (sample) untuk dashboard

## 7) Build Asset Frontend
```bash
npm run build
```

Untuk mode development (otomatis rebuild saat edit file):

```bash
npm run dev
```

## 8) Jalankan Aplikasi
```bash
php artisan serve
```

Buka browser:
- `http://127.0.0.1:8000`

## 9) Login Akun Demo
Project menyediakan halaman login dan register.

Untuk penggunaan biasa:
- buka halaman register
- buat akun baru
- login menggunakan akun yang sudah dibuat

## 10) Jika Gagal Jalan, Cek Ini
1. Error koneksi database
- pastikan MySQL aktif
- cek ulang isi `.env`

2. Halaman tidak update
- jalankan `php artisan optimize:clear`
- refresh browser (`Ctrl + F5`)

3. Asset/CSS berantakan
- jalankan ulang `npm install`
- lalu `npm run build`

4. Cache Laravel bermasalah
```bash
php artisan optimize:clear
php artisan config:clear
php artisan view:clear
```

## 11) Menjalankan Scheduler (Opsional)
Untuk fitur yang butuh scheduler Laravel:

```bash
php artisan schedule:work
```
