# Zero Nine Coffee Shop

![Laravel](https://img.shields.io/badge/Laravel-12.x-FF2D20?logo=laravel&logoColor=white)
![PHP](https://img.shields.io/badge/PHP-8.2%2B-777BB4?logo=php&logoColor=white)
![Livewire](https://img.shields.io/badge/Livewire-3.x-FB70A9?logo=livewire&logoColor=white)
![Tailwind CSS](https://img.shields.io/badge/Tailwind_CSS-4.x-38B2AC?logo=tailwindcss&logoColor=white)
![Vite](https://img.shields.io/badge/Vite-7.x-646CFF?logo=vite&logoColor=white)

Zero Nine Coffee Shop adalah aplikasi manajemen coffee shop berbasis Laravel untuk menangani katalog menu, pemesanan pelanggan, checkout, reservasi meja, loyalty point, admin panel, dan layar kasir. Project ini dibuat dengan arsitektur Laravel modern, Blade, Livewire Volt, Tailwind CSS, Alpine.js, serta integrasi payment gateway Midtrans dan Tripay.

## Fitur Utama

- Landing page Zero Nine Coffee Shop dengan pengalaman visual interaktif.
- Katalog menu dengan kategori, detail menu, featured item, best seller, stok, dan waktu persiapan.
- Keranjang belanja, promo code, checkout, riwayat pesanan, pembatalan pesanan, dan review.
- QR table ordering melalui route `/table/{number}/order`.
- Booking meja dengan jadwal, kapasitas, dan status reservasi.
- Loyalty system dengan tier Bronze, Silver, Gold, dan Platinum.
- Admin panel untuk dashboard, menu, kategori, promo, meja, inventory, pengguna, role, order, booking, dan review.
- Cashier panel untuk memantau order aktif, update status, verifikasi pembayaran, dan cetak struk.
- Role-based access control menggunakan Spatie Laravel Permission.
- Autentikasi email/password dengan Laravel Breeze, Livewire Volt, dan login Google OAuth.
- Integrasi Midtrans Snap dan Tripay untuk pembayaran online.
- Event real-time untuk update status order dan alert stok rendah.

## Tech Stack

| Area | Teknologi |
| --- | --- |
| Backend | Laravel 12, PHP 8.2+, Laravel Sanctum, Laravel Reverb |
| Frontend | Blade, Livewire 3, Volt, Alpine.js, Tailwind CSS 4, Vite |
| UI/Visual | Three.js, GSAP, ApexCharts |
| Database | MySQL/MariaDB, dapat disesuaikan lewat konfigurasi Laravel |
| Auth & Role | Laravel Breeze, Socialite Google OAuth, Spatie Permission |
| Payment | Midtrans Snap, Tripay |
| Export/Document | DomPDF, Laravel Excel |
| Testing | PHPUnit |

## Persyaratan

Pastikan environment lokal sudah memiliki:

- PHP `^8.2`
- Composer
- Node.js dan npm
- MySQL atau MariaDB
- Git

## Instalasi

Clone repository:

```bash
git clone <repository-url>
cd website-zeronine
```

Install dependency PHP dan JavaScript:

```bash
composer install
npm install
```

Buat file `.env` dari template:

```bash
# macOS/Linux/Git Bash
cp .env.example .env

# Windows PowerShell
Copy-Item .env.example .env
```

Setelah `.env` dibuat, generate application key:

```bash
php artisan key:generate
```

Siapkan database MySQL:

```sql
CREATE DATABASE zeronine_coffee;
```

Sesuaikan nama database, username, dan password pada file `.env`.

Jalankan migrasi, seeder, dan storage link:

```bash
php artisan migrate --seed
php artisan storage:link
```

Build asset frontend:

```bash
npm run build
```

## Quick Start

Gunakan langkah berikut untuk menjalankan project setelah clone repository:

```bash
git clone <repository-url>
cd website-zeronine

composer install
npm install

cp .env.example .env
php artisan key:generate
```

Untuk Windows PowerShell, ganti command copy env menjadi:

```powershell
Copy-Item .env.example .env
```

Buat database MySQL:

```sql
CREATE DATABASE zeronine_coffee;
```

Lalu sesuaikan bagian database di `.env`:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=zeronine_coffee
DB_USERNAME=root
DB_PASSWORD=
```

Jalankan setup database, asset, dan storage:

```bash
php artisan migrate --seed
php artisan storage:link
npm run build
```

Jalankan aplikasi:

```bash
composer run dev
```

Buka:

```text
http://127.0.0.1:8000
```

Login demo:

| Role | Email | Password |
| --- | --- | --- |
| Admin | `admin@zeronine.coffee` | `password` |
| Cashier | `kasir@zeronine.coffee` | `password` |
| Customer | `customer@demo.com` | `password` |

## Agar Gambar Menu Tampil

Gambar menu project ini disimpan di:

```text
storage/app/public/menus
```

Database hanya menyimpan path seperti `menus/nama-file.jpg`, lalu aplikasi menampilkannya lewat URL:

```text
/storage/menus/nama-file.jpg
```

Supaya gambar menu tampil normal:

- Pastikan folder `storage/app/public/menus` ikut di-push ke GitHub.
- Jangan commit folder `public/storage`; folder ini dibuat otomatis oleh `php artisan storage:link`.
- Setelah clone, jalankan `php artisan storage:link`.
- Jika gambar masih tidak tampil, cek apakah file gambar benar-benar ada di `storage/app/public/menus` dan `APP_URL` di `.env` sesuai URL lokal.

File `storage/app/public/.gitignore` di project ini sudah disesuaikan agar gambar `.jpg`, `.jpeg`, `.png`, dan `.webp` di folder `menus` bisa ikut GitHub.

## Menjalankan Project

Cara paling praktis untuk development:

```bash
composer run dev
```

Script tersebut menjalankan Laravel server, queue listener, Laravel Pail, dan Vite dev server secara bersamaan.

Jika ingin menjalankan service secara terpisah:

```bash
php artisan serve
npm run dev
php artisan queue:listen
```

Aplikasi default dapat dibuka di:

```text
http://127.0.0.1:8000
```

## Environment Penting

Contoh konfigurasi minimum untuk development lokal:

```env
APP_NAME="Zero Nine Coffee Shop"
APP_ENV=local
APP_KEY=
APP_DEBUG=true
APP_URL=http://127.0.0.1:8000

APP_LOCALE=id
APP_FALLBACK_LOCALE=en
APP_FAKER_LOCALE=id_ID

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=zeronine_coffee
DB_USERNAME=root
DB_PASSWORD=

CACHE_STORE=database
QUEUE_CONNECTION=database
SESSION_DRIVER=database
BROADCAST_CONNECTION=null

MAIL_MAILER=log
MAIL_FROM_ADDRESS="hello@zeronine.coffee"
MAIL_FROM_NAME="${APP_NAME}"
```

Konfigurasi opsional untuk fitur eksternal:

```env
# Google OAuth
GOOGLE_CLIENT_ID=
GOOGLE_CLIENT_SECRET=
GOOGLE_REDIRECT_URI="${APP_URL}/auth/google/callback"

# Midtrans
MIDTRANS_MERCHANT_ID=
MIDTRANS_CLIENT_KEY=
MIDTRANS_SERVER_KEY=
MIDTRANS_IS_PRODUCTION=false
MIDTRANS_IS_SANITIZED=true
MIDTRANS_IS_3DS=true

# Tripay
TRIPAY_API_KEY=
TRIPAY_PRIVATE_KEY=
TRIPAY_MERCHANT_CODE=
TRIPAY_MODE=sandbox

# Laravel Reverb, jika realtime broadcasting diaktifkan
REVERB_APP_ID=
REVERB_APP_KEY=
REVERB_APP_SECRET=
REVERB_HOST=127.0.0.1
REVERB_PORT=8080
REVERB_SCHEME=http
```

Jangan commit file `.env` ke repository publik. Simpan kredensial payment gateway, OAuth, mail, dan secret lain hanya di environment lokal atau secret manager deployment.

## Akun Demo

Seeder menyediakan akun berikut:

| Role | Email | Password |
| --- | --- | --- |
| Admin | `admin@zeronine.coffee` | `password` |
| Cashier | `kasir@zeronine.coffee` | `password` |
| Customer | `customer@demo.com` | `password` |

Jalankan `php artisan migrate --seed` untuk membuat role, permission, akun demo, membership tier, menu, kategori, dan meja.

## Route Utama

| Area | URL |
| --- | --- |
| Landing page | `/` |
| Katalog menu | `/menu` |
| Detail menu | `/menu/{slug}` |
| QR order meja | `/table/{number}/order` |
| Cart | `/cart` |
| Checkout | `/checkout` |
| Riwayat order | `/orders` |
| Booking meja | `/bookings` |
| Loyalty | `/loyalty` |
| Admin dashboard | `/admin/dashboard` |
| Cashier panel | `/cashier` |
| Midtrans callback | `/payment/notification` |
| Tripay callback | `/payment/tripay/callback` |

## Struktur Project

```text
app/
  Events/                 Event broadcast order dan stok
  Http/Controllers/       Controller customer, admin, cashier, auth, payment
  Http/Middleware/        Middleware status akun
  Models/                 Model domain coffee shop
  Repositories/           Abstraksi query untuk menu dan order
  Services/               Business logic cart, order, booking, loyalty, payment
database/
  migrations/             Skema database
  seeders/                Data awal role, user, membership, menu, meja
resources/
  css/                    Entry stylesheet
  js/                     Entry JavaScript, landing animation, bootstrap
  views/                  Blade view untuk guest, customer, admin, cashier
routes/
  web.php                 Route utama aplikasi
  auth.php                Route autentikasi Livewire Volt
public/
  index.php               Front controller Laravel
```

## Command Berguna

| Command | Fungsi |
| --- | --- |
| `composer run dev` | Menjalankan server, queue, log tail, dan Vite bersamaan |
| `php artisan serve` | Menjalankan Laravel development server |
| `npm run dev` | Menjalankan Vite development server |
| `npm run build` | Build asset untuk production |
| `php artisan migrate --seed` | Migrasi database dan isi data awal |
| `php artisan test` | Menjalankan test suite |
| `./vendor/bin/pint` | Format kode PHP dengan Laravel Pint |
| `php artisan optimize:clear` | Membersihkan cache config, route, view, dan app |

## Testing

Jalankan test:

```bash
php artisan test
```

Atau melalui Composer script:

```bash
composer test
```

## Catatan Deployment

- Set `APP_ENV=production`, `APP_DEBUG=false`, dan `APP_URL` sesuai domain production.
- Gunakan database MySQL/MariaDB production yang sudah diamankan dan dibackup berkala.
- Jalankan `php artisan migrate --force` saat deployment.
- Jalankan `npm run build` sebelum publish asset.
- Pastikan queue worker aktif untuk pekerjaan asynchronous.
- Konfigurasikan callback Midtrans dan Tripay ke domain production.
- Simpan semua credential di environment variable server, bukan di repository.
- Jalankan `php artisan config:cache`, `php artisan route:cache`, dan `php artisan view:cache` setelah konfigurasi production stabil.

## Kontribusi

1. Fork repository ini.
2. Buat branch fitur: `git checkout -b feature/nama-fitur`.
3. Commit perubahan dengan pesan yang jelas.
4. Push branch dan buat pull request.

Sebelum membuat pull request, pastikan test berjalan dan kode sudah diformat.

## Lisensi

Project ini menggunakan lisensi MIT sesuai konfigurasi `composer.json`.
