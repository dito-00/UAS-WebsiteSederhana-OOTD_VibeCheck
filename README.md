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
* *Halaman Login & Registrasi*

<img src="https://github.com/user-attachments/assets/2f11dda0-e1b8-4fd0-93a1-d1861e587bb3" width="500" alt="Halaman Tambah Item"> <img src="https://github.com/user-attachments/assets/9001aa1e-6b99-4acd-a7aa-359c0a24ad48" width="500" alt="Dashboard User">

* *Dashboard User (Halaman Utama)*

Tampilan Home:

<img width="500" alt="Screenshot (172)" src="https://github.com/user-attachments/assets/a82b3d2d-bdef-4944-b84a-8c68bfb33536" />
<img width="500" alt="Screenshot (173)" src="https://github.com/user-attachments/assets/5cd8c0a0-8e75-415e-868a-5071d56cc4f1" />
<p align="center"> <img width="500" alt="Screenshot (175)" src="https://github.com/user-attachments/assets/586c2d32-96d5-497e-a84c-88548c0a36f2" />

Fitur Pencarian:

<img width="500" alt="Screenshot (176)" src="https://github.com/user-attachments/assets/215c2508-ce79-4435-b014-f824e2b0422c" />
<img width="500" alt="Screenshot (177)" src="https://github.com/user-attachments/assets/5e321451-ea68-4139-8b6e-f32689b9f62d" />

* *Manajemen Pakaian (CRUD User)*

Form Tambah Item:

<img width="500" alt="Screenshot (178)" src="https://github.com/user-attachments/assets/1df19d60-7757-4ebf-aafb-c4a6bae8d8c5" />
<img width="500" alt="Screenshot (179)" src="https://github.com/user-attachments/assets/355e85f9-3106-48e4-8848-b8d6d0e7a457" />

Konfirmasi Hapus:

<img width="1366" height="768" alt="Screenshot (180)" src="https://github.com/user-attachments/assets/76dcfe08-6623-48f1-ad26-ce33d378128c" />

* *Dashboard Admin*
<img width="500" alt="Screenshot (181)" src="https://github.com/user-attachments/assets/3543ce46-ebe2-4689-999d-3b4f85583c29" />
<img width="500" alt="Screenshot (182)" src="https://github.com/user-attachments/assets/9899b0a3-b094-4e63-a6fa-f76662d9fc7a" />
<p align="center"> <img width="500" alt="Screenshot (182)" src="https://github.com/user-attachments/assets/f7dd2df5-5082-4fae-b3c5-25062bbda17e" />

