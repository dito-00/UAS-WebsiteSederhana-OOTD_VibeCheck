<?php
if (session_status() === PHP_SESSION_NONE) session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') { header("Location: index.php?url=login"); exit(); }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel - VibeCheck</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        body { font-family: 'Poppins', sans-serif; background: url('public/img/wallpaper.jpg') no-repeat center center fixed; background-size: cover; }
        .admin-container { background: rgba(255, 255, 255, 0.9); border-radius: 20px; padding: 30px; margin-top: 40px; margin-bottom: 40px; backdrop-filter: blur(5px); }
        .header-panel { background-color: rgba(255, 255, 255, 0.8) !important; border-radius: 15px; }
    </style>
</head>
<body>
<div class="container">
    <div class="admin-container shadow-lg">
        <div class="d-flex justify-content-between align-items-center mb-4 p-3 bg-white shadow-sm rounded-4 header-panel">
            <h2 class="fw-bold m-0">Admin Panel 🛠️</h2>
            <div class="d-flex align-items-center">
                <span class="me-3 fw-bold text-primary small">Hi, Admin (<?= $_SESSION['username'] ?>)</span>
                <a href="index.php?url=logout" class="btn btn-danger btn-sm rounded-pill px-3">Logout</a>
            </div>
        </div>

        <div class="card border-0 bg-transparent mb-5">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h4 class="fw-bold mb-0 text-dark">Manage Categories</h4>
                <form action="index.php?url=add_category" method="POST" class="d-flex gap-2">
                    <input type="text" name="name" class="form-control form-control-sm rounded-pill px-3 shadow-sm" placeholder="Kategori Baru..." required>
                    <button type="submit" class="btn btn-dark btn-sm rounded-pill px-3">Tambah</button>
                </form>
            </div>
            <div class="table-responsive bg-white rounded-4 p-2 shadow-sm">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr><th width="10%">No</th><th>Nama Kategori</th><th class="text-center">Total Pakaian</th><th width="20%" class="text-center">Aksi</th></tr>
                    </thead>
                    <tbody>
                        <?php
                        $query = "SELECT categories.*, COUNT(clothes.id) as total_items FROM categories LEFT JOIN clothes ON categories.id = clothes.category_id GROUP BY categories.id ORDER BY categories.name ASC";
                        $stmt = $db->query($query);
                        $no = 1;
                        while($row = $stmt->fetch(PDO::FETCH_ASSOC)):
                        ?>
                        <tr>
                            <td><?= $no++ ?></td> 
                            <td><span class="badge bg-info text-dark px-3 rounded-pill"><?= htmlspecialchars($row['name']) ?></span></td>
                            <td class="text-center"><span class="fw-bold text-dark"><?= $row['total_items'] ?></span> <small class="text-muted">Item</small></td>
                            <td class="text-center"><a href="javascript:void(0)" onclick="confirmDeleteCat('<?= $row['id'] ?>')" class="btn btn-sm btn-outline-danger rounded-pill px-3">Hapus</a></td>
                        </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="card border-0 bg-transparent">
            <h4 class="fw-bold mb-4 text-dark">Manage Users 👤</h4>
            <div class="table-responsive bg-white rounded-4 p-2 shadow-sm">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr><th>No</th><th>Username</th><th>Role</th><th class="text-center">Aksi</th></tr>
                    </thead>
                    <tbody>
                        <?php
                        $u_stmt = $db->query("SELECT * FROM users WHERE role = 'user' ORDER BY id DESC");
                        $no_u = 1;
                        while($u = $u_stmt->fetch(PDO::FETCH_ASSOC)):
                        ?>
                        <tr>
                            <td><?= $no_u++ ?></td>
                            <td><?= htmlspecialchars($u['username']) ?></td>
                            <td><span class="badge bg-secondary">User</span></td>
                            <td class="text-center"><button onclick="confirmDeleteUser('<?= $u['id'] ?>', '<?= $u['username'] ?>')" class="btn btn-sm btn-danger rounded-pill px-3">Hapus User</button></td>
                        </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script>
<?php if(isset($_GET['msg'])): ?>
    Swal.fire({ toast: true, position: 'top-end', icon: 'success', title: '<?= htmlspecialchars($_GET['msg']) ?>', showConfirmButton: false, timer: 3000, timerProgressBar: true });
    window.history.replaceState({}, document.title, window.location.pathname + "?url=admin_dashboard");
<?php endif; ?>

function confirmDeleteCat(id) {
    Swal.fire({ title: 'Hapus kategori?', text: "Kategori tidak bisa dihapus jika ada isinya!", icon: 'warning', showCancelButton: true, confirmButtonColor: '#1a1a1a', cancelButtonColor: '#d33', confirmButtonText: 'Ya, Hapus!', cancelButtonText: 'Batal' }).then((result) => { if (result.isConfirmed) window.location.href = "index.php?url=delete_category&id=" + id; });
}

function confirmDeleteUser(id, name) {
    Swal.fire({ title: 'Hapus User ' + name + '?', text: "Data user dan lemarinya akan dihapus permanen!", icon: 'error', showCancelButton: true, confirmButtonColor: '#d33', confirmButtonText: 'Ya, Hapus!' }).then((result) => { if (result.isConfirmed) window.location.href = "index.php?url=admin_delete_user&id=" + id; });
}
</script>
</body>
</html>