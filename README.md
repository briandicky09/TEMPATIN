# TEMPATIN

TEMPATIN adalah aplikasi web pencarian dan pengelolaan kos berbasis Laravel 12. Aplikasi ini dirancang untuk kebutuhan tiga peran utama:

- Pengunjung umum mencari kos
- Owner kos mengelola properti dan data listing
- Customer/member yang ingin melihat detail kos, booking, invoice, dan profil

Project ini menggunakan Blade templating, Bootstrap, dan struktur Laravel modern dengan routing, controller, model, serta view yang sudah dipisah sesuai area fungsi.

## Fitur utama

- Homepage TEMPATIN dengan rekomendasi kos unggulan
- Halaman pencarian dan detail kos publik
- Login dan registrasi untuk member/owner
- Area owner untuk:
  - dashboard
  - daftar kos
  - tambah/edit/hapus kos
  - penilaian
  - statistik
  - notifikasi
- Area customer/member untuk:
  - melihat kos
  - booking
  - invoice
  - profil dan notifikasi
- Struktur route yang sudah dibagi berdasarkan role dan area fitur
- UI dibuat konsisten dengan template frontend yang sebelumnya dikonversi ke Laravel

## Tech stack

- Laravel 12
- PHP 8.2
- Blade
- Bootstrap
- MySQL / SQLite / database sesuai konfigurasi local

## Struktur project

```bash
app/
├── Http/
│   ├── Controllers/
│   └── Requests/
├── Models/
├── Policies/
├── Providers/
config/
database/
public/
resources/
├── views/
routes/
storage/
tests/
.env.example
artisan
composer.json
phpunit.xml
```

## Persyaratan

- PHP ^8.2
- Composer
- Database (MySQL/PostgreSQL/SQLite)
- Web server lokal (misalnya Laravel artisan serve)

## Instalasi

1. Clone repository:

```bash
git clone https://github.com/briandicky09/TEMPATIN.git
cd TEMPATIN
```

2. Install dependency PHP:

```bash
composer install
```

3. Copy file environment:

```bash
cp .env.example .env
```

4. Generate application key:

```bash
php artisan key:generate
```

5. Konfigurasi database di file `.env`.

Contoh konfigurasi MySQL:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=tempatin
DB_USERNAME=root
DB_PASSWORD=
```

6. Jalankan migrasi database:

```bash
php artisan migrate
```

7. Jalankan aplikasi:

```bash
php artisan serve
```

Akses aplikasi di:

```text
http://localhost:8000
```

## Route penting

Beberapa route utama yang tersedia:

```text
/
/login
/register
/kos
/kos/{slug}
/owner
/owner/kos
/owner/kos/create
/customer/kos
/member
```

## Status project

Project ini masih dalam tahap pengembangan fitur, dengan fokus utama pada struktur aplikasi, manajemen kos, autentikasi, dan alur role-based access.

## Kontribusi

Pull request dan saran pengembangan sangat terbuka. Untuk perubahan besar, disarankan untuk membuka issue terlebih dahulu agar arah pengembangan dapat dibahas lebih jelas.

## Lisensi

Project ini menggunakan lisensi MIT.
