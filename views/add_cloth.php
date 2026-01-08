<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'user') {
    header("Location: index.php?url=login");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add New Vibe - VibeCheck</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <style>
        body { 
            font-family: 'Poppins', sans-serif; 
            background: url('public/img/wallpaper.jpg') no-repeat center center fixed; 
            background-size: cover;
            min-height: 100vh;
            display: flex;
            align-items: center;
        }
        .add-card {
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(10px);
            border-radius: 25px;
            padding: 40px;
            box-shadow: 0 15px 35px rgba(0,0,0,0.2);
            border: 1px solid rgba(255, 255, 255, 0.3);
            width: 100%;
            max-width: 550px;
            margin: auto;
            position: relative;
        }
        .form-logo {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            object-fit: cover;
            display: block;
            margin: -80px auto 20px auto; /* Membuat logo sedikit 'melayang' keluar card */
            border: 5px solid white;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        }
        .form-label { font-weight: 600; font-size: 0.9rem; color: #333; }
        .form-control, .form-select {
            border-radius: 12px;
            padding: 12px 20px;
            border: 1px solid #ddd;
            background: rgba(255, 255, 255, 0.8);
        }
        .form-control:focus { box-shadow: 0 0 0 0.25rem rgba(0,0,0,0.1); border-color: #333; }
        .btn-save { background: #1a1a1a; color: white; border-radius: 12px; padding: 12px; font-weight: 600; transition: 0.3s; }
        .btn-save:hover { background: #000; transform: translateY(-2px); }
        .preview-box { width: 100%; height: 200px; border: 2px dashed #ccc; border-radius: 15px; display: flex; align-items: center; justify-content: center; overflow: hidden; background: #f8f9fa; margin-bottom: 20px; }
        .preview-box img { width: 100%; height: 100%; object-fit: cover; display: none; }
    </style>
</head>
<body>

<div class="container d-flex justify-content-center py-5 mt-4">
    <div class="add-card shadow-lg">
        <img src="public/img/logo.jpg" alt="Logo" class="form-logo">
        
        <div class="text-center mb-4">
            <h3 class="fw-bold">Tambah Koleksi Baru</h3>
            <p class="text-muted small">Abadikan gaya terbaikmu ke dalam closet digital</p>
        </div>
        
        <form action="index.php?url=process_add" method="POST" enctype="multipart/form-data">
            
            <label class="form-label d-block text-center">Pratinjau Foto</label>
            <div class="preview-box" id="previewContainer">
                <span class="text-muted small" id="previewText">Belum ada foto terpilih</span>
                <img id="imagePreview" src="" alt="Preview">
            </div>

            <div class="mb-3">
                <label class="form-label">Nama Pakaian</label>
                <input type="text" name="name" class="form-control" placeholder="Contoh: Kemeja Flanel Uniqlo" required>
            </div>

            <div class="row mb-3">
                <div class="col-md-6">
                    <label class="form-label">Vibe / Style</label>
                    <input type="text" name="vibe" class="form-control" placeholder="#Streetwear" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Kategori</label>
                    <select name="category_id" class="form-select" required>
                        <option value="" disabled selected>Pilih Kategori</option>
                        <?php
                        $stmt = $db->query("SELECT * FROM categories ORDER BY name ASC");
                        while($row = $stmt->fetch(PDO::FETCH_ASSOC)):
                        ?>
                            <option value="<?= $row['id'] ?>"><?= htmlspecialchars($row['name']) ?></option>
                        <?php endwhile; ?>
                    </select>
                </div>
            </div>

            <div class="mb-4">
                <label class="form-label">Unggah Foto (JPG/PNG)</label>
                <input type="file" name="image" id="imageInput" class="form-control" accept="image/*" required>
            </div>

            <div class="d-grid gap-2">
                <button type="submit" class="btn btn-save shadow">Simpan ke Closet</button>
                <a href="index.php?url=dashboard" class="btn btn-link text-decoration-none text-muted small">Batal dan Kembali</a>
            </div>
        </form>
    </div>
</div>

<script>
    const imageInput = document.getElementById('imageInput');
    const imagePreview = document.getElementById('imagePreview');
    const previewText = document.getElementById('previewText');

    imageInput.onchange = evt => {
        const [file] = imageInput.files;
        if (file) {
            imagePreview.src = URL.createObjectURL(file);
            imagePreview.style.display = 'block';
            previewText.style.display = 'none';
        }
    }
</script>

</body>
</html>