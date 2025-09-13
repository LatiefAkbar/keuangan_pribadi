# Sistem Manajemen Keuangan Pribadi

Sistem Manajemen Keuangan Pribadi ini dibuat menggunakan **PHP Native** dan **MySQL** dengan tampilan menggunakan **Tailwind CSS**. Sistem ini memungkinkan pengguna untuk mencatat pemasukan, pengeluaran, melihat saldo, dan membuat laporan keuangan.

## Fitur
- Autentikasi pengguna (Login & Logout)
- Registrasi akun baru
- Tambah, edit, dan hapus transaksi keuangan
- Ringkasan keuangan:
  - Saldo
  - Total pemasukan
  - Total pengeluaran
- Laporan transaksi dengan filter tanggal (opsional)
- Tampilan responsif menggunakan Tailwind CSS
- Konfirmasi saat menghapus transaksi

## Struktur Folder
/config -> berisi koneksi database
/includes -> berisi file autentikasi (auth.php)
/transaksi -> berisi tambah, edit, hapus transaksi
/dashboard.php -> halaman utama setelah login
/laporan.php -> halaman laporan keuangan
/index.php -> halaman login
/register.php -> halaman registrasi
/logout.php -> halaman logout

markdown
Salin kode

## Instalasi
1. Clone repository ini ke folder web server (misal XAMPP `htdocs` atau WAMP):
   ```bash
   git clone <URL_REPO> keuangan_pribadi
Buat database MySQL misal keuangan_pribadi.

Import file SQL (jika ada) atau buat tabel:

sql
Salin kode
CREATE TABLE users (
    id INT PRIMARY KEY AUTO_INCREMENT,
    username VARCHAR(50) UNIQUE,
    password VARCHAR(255)
);

CREATE TABLE transaksi (
    id INT PRIMARY KEY AUTO_INCREMENT,
    user_id INT,
    tanggal DATE,
    jenis ENUM('pemasukan','pengeluaran'),
    kategori VARCHAR(50),
    jumlah INT,
    keterangan TEXT,
    FOREIGN KEY(user_id) REFERENCES users(id)
);
Sesuaikan konfigurasi database di config/db.php:

php
Salin kode
<?php
$conn = mysqli_connect("localhost", "root", "", "keuangan_pribadi");

if (!$conn) {
    die("Koneksi gagal: " . mysqli_connect_error());
}
?>

Jalankan project di browser:

http://localhost/keuangan_pribadi/index.php
Cara Pakai
Registrasi akun baru di register.php.

Login dengan akun yang sudah dibuat.

Tambah transaksi melalui + Tambah Transaksi.

Edit atau hapus transaksi melalui tombol di tabel.

Lihat ringkasan saldo, pemasukan, dan pengeluaran di dashboard.

Akses laporan melalui tombol Lihat Laporan.

Teknologi
PHP Native

MySQL / MariaDB

Tailwind CSS

HTML & CSS

Catatan
Pastikan PHP minimal versi 7.4 untuk mendukung password_hash() dan password_verify().

Disarankan menggunakan browser modern untuk tampilan Tailwind CSS yang optimal.

Hati-hati saat menghapus data transaksi karena aksi ini permanen.

Dibuat oleh: Latif Akbar Maulana
Tanggal: 2025

markdown

