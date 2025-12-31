# Panduan Deployment Niagahoster (Laravel Shared Hosting)

Panduan ini menjelaskan cara memindahkan HRMS Anda ke **Niagahoster Shared Hosting** agar data aman dan stabil.

## 1. Persiapan di CPanel Niagahoster
1.  **MySQL Database**:
    *   Buka **MySQL Database Wizard**.
    *   Buat database (misal: `u123_hrms`).
    *   Buat user database (misal: `u123_user`) dan catat passwordnya.
2.  **PHP Version**: Pastikan versi PHP disetel ke **8.2** atau **8.3**.

## 2. Persiapan File (Lokal)
1.  Ganti isi `.env` Anda menjadi menggunakan MySQL:
    ```env
    DB_CONNECTION=mysql
    DB_HOST=127.0.0.1
    DB_PORT=3306
    DB_DATABASE=nama_database_cpanel
    DB_USERNAME=nama_user_cpanel
    DB_PASSWORD=password_user_cpanel
    ```
2.  Jalankan perintah lokal untuk optimasi:
    ```bash
    php artisan config:cache
    php artisan route:cache
    php artisan view:cache
    npm run build
    ```
3.  **Zip Project**: Kompres semua file di direktori `hrms` kecuali folder `node_modules`, `tests`, dan `.git`.

## 3. Upload ke File Manager
1.  Upload file Zip ke CPanel (di luar folder `public_html` sangat disarankan untuk keamanan).
2.  Ekstrak file Zip tersebut.
3.  Pindahkan isi dari folder **`public`** aplikasi Anda ke dalam folder **`public_html`** hosting.
4.  Edit file `index.php` di dalam `public_html`:
    *   Ubah path `autoload.php` dan `app.php` agar mengarah ke lokasi folder utama tempat Anda mengekstrak tadi.

## 4. Migrasi Database
1.  Buka **phpMyAdmin** di CPanel.
2.  Import file `.sql` (Hasil export dari database lokal Anda).

> [!TIP]
> Niagahoster sangat stabil untuk Laravel. Jika Anda butuh bantuan saat memindahkan file ke CPanel, saya bisa memberikan instruksi yang lebih mendetail terkait struktur foldernya.
