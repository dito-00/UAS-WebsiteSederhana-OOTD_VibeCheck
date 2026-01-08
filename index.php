<?php
session_start();
require_once 'app/Database.php';
require_once 'app/Models/Cloth.php';

$database = new Database();
$db = $database->getConnection();

$url = isset($_GET['url']) ? $_GET['url'] : 'login';

switch ($url) {
    case 'login':
        include 'views/login.php';
        break;

    case 'register_process':
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $user = $_POST['username'];
            $pass = $_POST['password']; // Sebaiknya gunakan password_hash() untuk keamanan
            $stmt = $db->prepare("INSERT INTO users (username, password, role) VALUES (?, ?, 'user')");
            if($stmt->execute([$user, $pass])) {
                header("Location: index.php?url=login&msg=Akun berhasil dibuat! Silakan Login");
                exit();
            }
        }
        break;

    case 'auth':
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $username = $_POST['username'] ?? '';
            $password = $_POST['password'] ?? '';
            $stmt = $db->prepare("SELECT * FROM users WHERE username = :user");
            $stmt->execute(['user' => $username]);
            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($user && ($password == $user['password'] || password_verify($password, $user['password']))) {
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['username'] = $user['username'];
                $_SESSION['role'] = $user['role'];
                $target = ($user['role'] == 'admin') ? 'admin_dashboard' : 'dashboard';
                header("Location: index.php?url=" . $target);
                exit();
            } else {
                header("Location: index.php?url=login&error=Username atau Password Salah!");
                exit();
            }
        }
        break;

    case 'dashboard':
        if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'user') {
            header("Location: index.php?url=login");
            exit();
        }
        include 'views/dashboard.php';
        break;

    case 'delete_self':
        if (isset($_SESSION['user_id'])) {
            $uid = $_SESSION['user_id'];
            $stmt_img = $db->prepare("SELECT image FROM clothes WHERE user_id = ?");
            $stmt_img->execute([$uid]);
            while($img = $stmt_img->fetch()) {
                if (file_exists("public/uploads/" . $img['image'])) unlink("public/uploads/" . $img['image']);
            }
            $db->prepare("DELETE FROM users WHERE id = ?")->execute([$uid]);
            session_destroy();
            header("Location: index.php?url=login&msg=Akun Anda telah dihapus");
            exit();
        }
        break;

    case 'add_cloth':
        if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'user') {
            header("Location: index.php?url=login");
            exit();
        }
        include 'views/add_cloth.php';
        break;

    case 'process_add':
        if ($_SERVER['REQUEST_METHOD'] == 'POST' && $_SESSION['role'] == 'user') {
            $target_dir = "public/uploads/";
            if (!is_dir($target_dir)) mkdir($target_dir, 0777, true);
            $file_ext = pathinfo($_FILES["image"]["name"], PATHINFO_EXTENSION);
            $new_filename = uniqid() . "." . $file_ext;
            
            if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_dir . $new_filename)) {
                $query = "INSERT INTO clothes (user_id, category_id, name, vibe, image) VALUES (:uid, :cat, :name, :vibe, :img)";
                $stmt = $db->prepare($query);
                $stmt->execute([
                    'uid' => $_SESSION['user_id'], 
                    'cat' => $_POST['category_id'], 
                    'name' => $_POST['name'], 
                    'vibe' => $_POST['vibe'], 
                    'img' => $new_filename
                ]);
                header("Location: index.php?url=dashboard&msg=Baju Berhasil Ditambahkan");
                exit();
            }
        }
        break;

    case 'update_status':
        if (isset($_GET['id']) && isset($_GET['status']) && $_SESSION['role'] == 'user') {
            $new_status = ($_GET['status'] == 'Ready') ? 'Dirty' : 'Ready';
            $stmt = $db->prepare("UPDATE clothes SET status = :status WHERE id = :id AND user_id = :uid");
            $stmt->execute(['status' => $new_status, 'id' => $_GET['id'], 'uid' => $_SESSION['user_id']]);
        }
        header("Location: index.php?url=dashboard");
        exit();
        break;

    case 'delete_cloth':
        if (isset($_GET['id']) && $_SESSION['role'] == 'user') {
            $stmt_img = $db->prepare("SELECT image FROM clothes WHERE id = :id AND user_id = :uid");
            $stmt_img->execute(['id' => $_GET['id'], 'uid' => $_SESSION['user_id']]);
            $row = $stmt_img->fetch(PDO::FETCH_ASSOC);
            if ($row && file_exists("public/uploads/" . $row['image'])) unlink("public/uploads/" . $row['image']);
            
            $stmt = $db->prepare("DELETE FROM clothes WHERE id = :id AND user_id = :uid");
            $stmt->execute(['id' => $_GET['id'], 'uid' => $_SESSION['user_id']]);
        }
        header("Location: index.php?url=dashboard");
        exit();
        break;

    case 'admin_dashboard':
        if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'admin') {
            header("Location: index.php?url=login");
            exit();
        }
        include 'views/admin_dashboard.php';
        break;

    case 'admin_delete_user':
        if ($_SESSION['role'] == 'admin' && isset($_GET['id'])) {
            $id = $_GET['id'];
            $stmt_img = $db->prepare("SELECT image FROM clothes WHERE user_id = ?");
            $stmt_img->execute([$id]);
            while($img = $stmt_img->fetch()) {
                if (file_exists("public/uploads/" . $img['image'])) unlink("public/uploads/" . $img['image']);
            }
            $db->prepare("DELETE FROM users WHERE id = ?")->execute([$id]);
            header("Location: index.php?url=admin_dashboard&msg=User berhasil dihapus");
            exit();
        }
        break;

    case 'add_category':
        if ($_SESSION['role'] == 'admin' && isset($_POST['name'])) {
            $stmt = $db->prepare("INSERT INTO categories (name) VALUES (:name)");
            $stmt->execute(['name' => $_POST['name']]);
            header("Location: index.php?url=admin_dashboard&msg=Kategori Berhasil Ditambah");
            exit();
        }
        break;

    case 'delete_category':
        if ($_SESSION['role'] == 'admin' && isset($_GET['id'])) {
            $check = $db->prepare("SELECT COUNT(*) FROM clothes WHERE category_id = :id");
            $check->execute(['id' => $_GET['id']]);
            
            if ($check->fetchColumn() > 0) {
                header("Location: index.php?url=admin_dashboard&error_cat=Masih ada pakaian yang terdaftar di kategori ini!");
                exit();
            } else {
                $stmt = $db->prepare("DELETE FROM categories WHERE id = :id");
                $stmt->execute(['id' => $_GET['id']]);
                header("Location: index.php?url=admin_dashboard&msg=Kategori berhasil dihapus");
                exit();
            }
        }
        break;

    case 'logout':
        session_destroy();
        header("Location: index.php?url=login");
        exit();
        break;

    default:
        echo "404 - Halaman Tidak Ditemukan";
        break;
}