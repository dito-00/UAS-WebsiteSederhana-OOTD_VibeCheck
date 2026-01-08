# VibeCheck 👔 - Sistem Manajemen Lemari Digital

VibeCheck adalah aplikasi berbasis web yang dirancang untuk membantu pengguna mengelola koleksi pakaian mereka secara digital. Proyek ini dibuat untuk memenuhi tugas **UAS Pemrograman Web** dengan standar **OOP (Object Oriented Programming)** dan **Modular**.

## 🌟 Fitur Utama
* **Sistem Multi-Role**: Tersedia akses khusus untuk Admin dan User.
* **Manajemen Pakaian (CRUD)**: User dapat menambah, melihat, mengubah status (Ready/Dirty), dan menghapus pakaian.
* **Grouping Kategori**: Pakaian dikelompokkan secara otomatis berdasarkan kategori (Atasan, Bawahan, dll).
* **Fitur Pencarian**: Mencari pakaian berdasarkan nama atau "vibe" tertentu.
* **Pagination**: Membatasi tampilan data per halaman agar lebih rapi.
* **Keamanan Data**: Menggunakan relasi `ON DELETE CASCADE` sehingga saat akun dihapus, seluruh data pakaian terkait ikut terhapus secara otomatis.
* **UI/UX Modern**: Desain Glassmorphism yang responsif (Mobile First) menggunakan Bootstrap.

## 🛠️ Teknologi yang Digunakan
* **Bahasa**: PHP 8.x (OOP & Modular) 
* **Database**: MySQL (PDO Connection)
* **Frontend**: HTML5, CSS3, Bootstrap 5.3 
* **Library**: SweetAlert2 (Notifikasi Pop-up)

## 📁 Struktur Direktori
- `app/`: Berisi logika inti (Database & Models) [cite: 13]
- `public/`: Berisi aset (CSS, Gambar, Logo, Uploads) [cite: 13]
- `views/`: Berisi file tampilan UI [cite: 13]
- `index.php`: Sebagai Router utama aplikasi 

## 📸 Screenshots
*(Silakan masukkan screenshot aplikasi Anda di sini setelah melakukan demo)*
