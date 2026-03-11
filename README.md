# Cireng Rujak Kota Serang

Web aplikasi pemesanan UMKM Cireng Rujak untuk kebutuhan tugas/skripsi/demo akademik.

## Ringkasan Proyek
Project ini adalah sistem pemesanan online berbasis Laravel dengan fitur utama:

- Registrasi/login customer dan admin
- Checkout produk dan simulasi pembayaran
- Dashboard customer untuk memantau status pesanan
- Dashboard admin untuk validasi dan proses pesanan
- Riwayat pesanan dan trend penjualan

## Catatan Penting (Konteks Tugas)
Project ini dibuat untuk kebutuhan tugas pembelajaran, bukan untuk operasional bisnis produksi.

- Alur pembayaran menggunakan simulasi (mock payment), bukan payment gateway live.
- Alur bisnis disederhanakan agar mudah dipahami mahasiswa/pemula.
- Belum mencakup aspek enterprise seperti audit trail penuh, refund production, hardening keamanan tingkat tinggi, dan SLA operasional.

## Teknologi dan Library
### Backend
- PHP 8.2+
- Laravel 12
- MySQL/MariaDB
- Eloquent ORM

### Frontend
- Blade Template (Laravel)
- Tailwind CSS
- Alpine.js
- AOS (animation)
- Chart.js (visualisasi trend dashboard)
- SweetAlert2

### Tooling
- Composer
- Node.js + npm
- Vite

## Struktur Modul Utama
- Customer:
  - Buat pesanan
  - Simulasi pembayaran
  - Lihat status dan detail pesanan
- Admin:
  - Lihat antrian pesanan
  - Update status alur operasional
  - Lihat riwayat pesanan
  - Pantau trend penjualan

## Akun Demo Default
Setelah seeding:

- Admin
  - Email: `admin@cireng.test`
  - Password: `password`
- Customer
  - Email: `test@example.com`
  - Password: `password`

## Cara Menjalankan
Panduan lengkap ada di file:

- [PANDUAN-RUN-PROJECT.md](./PANDUAN-RUN-PROJECT.md)

## Persiapan Push ke GitHub
Pastikan file/folder berikut tidak ikut ter-push:

- `.env`
- `vendor/`
- `node_modules/`
- `.blackbox/`
- `.blackboxrules`
- folder lokal AI/tooling lain

Jika folder tersebut sudah terlanjur ke-track Git, gunakan:

```bash
git rm -r --cached .blackbox .blackboxrules node_modules vendor .env
```

Lalu commit ulang.

## Lisensi
Untuk kebutuhan pembelajaran/akademik internal.
