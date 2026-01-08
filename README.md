# VibeCheck 👔 - Digital Closet Management System

VibeCheck adalah aplikasi berbasis web yang dirancang untuk membantu pengguna mengelola koleksi pakaian mereka secara digital. [cite_start]Proyek ini dibuat untuk memenuhi tugas **UAS Pemrograman Web** dengan standar **OOP (Object Oriented Programming)** dan **Modular**[cite: 2, 6].

## 🌟 Fitur Utama
* [cite_start]**Sistem Multi-Role**: Tersedia akses khusus untuk Admin dan User[cite: 9].
* [cite_start]**Manajemen Pakaian (CRUD)**: User dapat menambah, melihat, mengubah status (Ready/Dirty), dan menghapus pakaian.
* **Grouping Kategori**: Pakaian dikelompokkan secara otomatis berdasarkan kategori (Atasan, Bawahan, dll).
* [cite_start]**Fitur Pencarian**: Mencari pakaian berdasarkan nama atau "vibe" tertentu.
* [cite_start]**Pagination**: Membatasi tampilan data per halaman agar lebih rapi.
* **Keamanan Data**: Menggunakan relasi `ON DELETE CASCADE` sehingga saat akun dihapus, seluruh data pakaian terkait ikut terhapus secara otomatis.
* [cite_start]**UI/UX Modern**: Desain Glassmorphism yang responsif (Mobile First) menggunakan Bootstrap.

## 🛠️ Teknologi yang Digunakan
* [cite_start]**Bahasa**: PHP 8.x (OOP & Modular) 
* **Database**: MySQL (PDO Connection)
* [cite_start]**Frontend**: HTML5, CSS3, Bootstrap 5.3 
* **Library**: SweetAlert2 (Notifikasi Pop-up)

## 📁 Struktur Direktori
- [cite_start]`app/`: Berisi logika inti (Database & Models) [cite: 13]
- [cite_start]`public/`: Berisi aset (CSS, Gambar, Logo, Uploads) [cite: 13]
- [cite_start]`views/`: Berisi file tampilan UI [cite: 13]
- [cite_start]`index.php`: Sebagai Router utama aplikasi 

## 📸 Screenshots
*(Silakan masukkan screenshot aplikasi Anda di sini setelah melakukan demo)*
