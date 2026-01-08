<?php
if (session_status() === PHP_SESSION_NONE) session_start();
if (!isset($_SESSION['user_id'])) { header("Location: index.php?url=login"); exit(); }

$search = isset($_GET['q']) ? $_GET['q'] : '';
$categories_stmt = $db->query("SELECT * FROM categories ORDER BY name ASC");
$all_categories = $categories_stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Closet - VibeCheck</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        body { font-family: 'Poppins', sans-serif; background: url('public/img/wallpaper.jpg') no-repeat center center fixed; background-size: cover; }
        .container-main { background: rgba(255, 255, 255, 0.85); border-radius: 20px; padding: 30px; margin-top: 20px; margin-bottom: 40px; backdrop-filter: blur(5px); }
        .category-header { border-left: 5px solid #1a1a1a; padding-left: 15px; margin-bottom: 25px; margin-top: 10px; color: #1a1a1a; text-transform: uppercase; letter-spacing: 1px; }
        .card { border-radius: 15px; border: none; overflow: hidden; transition: 0.3s; background: white; }
        .card:hover { transform: translateY(-5px); box-shadow: 0 10px 20px rgba(0,0,0,0.2) !important; }
        .img-closet { height: 180px; object-fit: cover; }
        .navbar { backdrop-filter: blur(10px); background-color: rgba(33, 37, 41, 0.9) !important; }
        .navbar-logo { width: 40px; height: 40px; border-radius: 50%; object-fit: cover; margin-right: 10px; border: 2px solid rgba(255,255,255,0.5); }
        .badge-count { font-size: 0.7rem; vertical-align: middle; }
    </style>
</head>
<body>
<nav class="navbar navbar-dark bg-dark mb-4 shadow-sm sticky-top">
    <div class="container">
        <a class="navbar-brand fw-bold d-flex align-items-center" href="index.php?url=dashboard">
            <img src="public/img/logo.jpg" alt="Logo" class="navbar-logo">
            VibeCheck
        </a>
        <div class="d-flex align-items-center">
            <span class="text-light me-3 small">Hi, <?= $_SESSION['username'] ?></span>
            <a href="javascript:void(0)" onclick="confirmDeleteSelf()" class="btn btn-sm btn-warning rounded-pill me-2">Hapus Akun</a>
            <a href="index.php?url=logout" class="btn btn-sm btn-outline-danger rounded-pill">Logout</a>
        </div>
    </div>
</nav>

<div class="container container-main shadow-lg">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="fw-bold">My Digital Closet</h4>
        <a href="index.php?url=add_cloth" class="btn btn-dark rounded-pill shadow-sm">+ Add Item</a>
    </div>

    <form method="GET" action="index.php" class="mb-5">
        <input type="hidden" name="url" value="dashboard">
        <div class="input-group shadow-sm rounded-pill overflow-hidden">
            <input type="text" name="q" class="form-control border-0 ps-4" placeholder="Cari vibe atau nama baju..." value="<?= htmlspecialchars($search) ?>">
            <button class="btn btn-dark px-4" type="submit">Cari</button>
        </div>
    </form>

    <?php 
    $found_any = false;
    foreach ($all_categories as $cat): 
        $sql = "SELECT * FROM clothes WHERE user_id = :uid AND category_id = :cid";
        if (!empty($search)) $sql .= " AND (name LIKE :q OR vibe LIKE :q)";
        $sql .= " ORDER BY id DESC";
        $item_stmt = $db->prepare($sql);
        $params = ['uid' => $_SESSION['user_id'], 'cid' => $cat['id']];
        if (!empty($search)) $params['q'] = "%$search%";
        $item_stmt->execute($params);
        $items = $item_stmt->fetchAll(PDO::FETCH_ASSOC);

        if (count($items) > 0): 
            $found_any = true;
    ?>
        <div class="category-group mb-5">
            <h5 class="fw-bold category-header"><?= htmlspecialchars($cat['name']) ?> <span class="badge bg-dark rounded-pill badge-count ms-2"><?= count($items) ?> Items</span></h5>
            <div class="row">
                <?php foreach ($items as $row): ?>
                <div class="col-6 col-md-4 col-lg-3 mb-4">
                    <div class="card shadow-sm h-100">
                        <img src="public/uploads/<?= $row['image'] ?>" class="img-closet">
                        <div class="card-body p-3">
                            <h6 class="fw-bold mb-1 text-truncate"><?= htmlspecialchars($row['name']) ?></h6>
                            <p class="text-muted mb-2 small italic" style="font-size: 0.75rem;">#<?= htmlspecialchars($row['vibe']) ?></p>
                            <div class="d-flex justify-content-between align-items-center mt-auto">
                                <span class="badge <?= $row['status'] == 'Ready' ? 'bg-success' : 'bg-warning text-dark' ?>" style="font-size: 0.65rem;"><?= $row['status'] ?></span>
                                <div class="btn-group shadow-sm">
                                    <a href="index.php?url=update_status&id=<?= $row['id'] ?>&status=<?= $row['status'] ?>" class="btn btn-sm btn-light py-0 px-2" title="Ubah Status">🔄</a>
                                    <a href="javascript:void(0)" onclick="confirmDelete('<?= $row['id'] ?>')" class="btn btn-sm btn-light text-danger py-0 px-2">🗑️</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    <?php endif; endforeach; 
    if (!$found_any): ?>
        <div class="text-center py-5"><h1 class="display-1">😶</h1><p class="text-muted mt-3">Tidak ditemukan pakaian.</p></div>
    <?php endif; ?>
</div>

<script>
<?php if(isset($_GET['msg'])): ?>
    Swal.fire({ toast: true, position: 'top-end', icon: 'success', title: '<?= htmlspecialchars($_GET['msg']) ?>', showConfirmButton: false, timer: 3000, timerProgressBar: true });
    window.history.replaceState({}, document.title, window.location.pathname + "?url=dashboard");
<?php endif; ?>

function confirmDelete(id) {
    Swal.fire({ title: 'Hapus baju ini?', text: "Koleksi kamu bakal ilang dari lemari digital!", icon: 'warning', showCancelButton: true, confirmButtonColor: '#1a1a1a', cancelButtonColor: '#d33', confirmButtonText: 'Ya, Hapus!', cancelButtonText: 'Batal' }).then((result) => { if (result.isConfirmed) window.location.href = "index.php?url=delete_cloth&id=" + id; });
}

function confirmDeleteSelf() {
    Swal.fire({ title: 'Hapus akun Anda?', text: "Semua data pakaian Anda akan hilang selamanya!", icon: 'warning', showCancelButton: true, confirmButtonColor: '#d33', cancelButtonColor: '#1a1a1a', confirmButtonText: 'Ya, Hapus Akun Saya!', cancelButtonText: 'Batal' }).then((result) => { if (result.isConfirmed) window.location.href = "index.php?url=delete_self"; });
}
</script>
</body>
</html>