<?php
session_start();
require 'db.php';

// Kiểm tra đăng nhập
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit;
}

$msg = '';

// Xử lý thêm/sửa/xoá
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['add_food'])) {
        $stmt = $pdo->prepare("INSERT INTO foods (name, price, category, image, description) VALUES (?, ?, ?, ?, ?)");
        $stmt->execute([
            $_POST['name'],
            $_POST['price'],
            $_POST['category'] ?? '',
            $_POST['image'] ?? '',
            $_POST['description'] ?? ''
        ]);
        $msg = "✅ Đã thêm món ăn!";
    }

    if (isset($_POST['update_food'])) {
        $stmt = $pdo->prepare("UPDATE foods SET name = ?, price = ?, category = ?, image = ?, description = ? WHERE id = ?");
        $stmt->execute([
            $_POST['name'],
            $_POST['price'],
            $_POST['category'] ?? '',
            $_POST['image'] ?? '',
            $_POST['description'] ?? '',
            $_POST['id']
        ]);
        $msg = "✅ Đã cập nhật món ăn!";
    }

    if (isset($_POST['delete_food'])) {
        $stmt = $pdo->prepare("DELETE FROM foods WHERE id = ?");
        $stmt->execute([$_POST['id']]);
        $msg = "🗑️ Đã xoá món ăn!";
    }
}

$foods = $pdo->query("SELECT * FROM foods")->fetchAll();
$reservations = $pdo->query("SELECT * FROM reservations ORDER BY datetime DESC")->fetchAll(); // đảm bảo biến này có
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Quản lý Món Ăn</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@500;600&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Quicksand', sans-serif; }
        img.thumb { height: 50px; object-fit: cover; }
    </style>
</head>
<body class="bg-light">

<div class="container py-4">
    <div class="text-center mb-4">
        <h1 class="text-primary">🍽️ Trang Quản Trị Món Ăn</h1>
    </div>

    <nav class="navbar navbar-expand-lg navbar-light bg-light px-3 mb-3">
        <a class="navbar-brand fw-bold" href="index.php">🍗 Gà Rán Ngon</a>
        <div class="ms-auto">
            <span class="me-3 fw-semibold text-primary">
                Xin chào, <?= $_SESSION['username'] ?? 'Admin' ?>
            </span>
            <a href="logout.php" class="btn btn-sm btn-danger">
                <i class="bi bi-box-arrow-right"></i> Đăng xuất
            </a>
        </div>
    </nav>

    <?php if (!empty($msg)): ?>
        <div class="alert alert-success text-center"><?= $msg ?></div>
    <?php endif; ?>

    <!-- Form thêm món ăn -->
    <div class="card mb-4">
        <div class="card-header bg-success text-white">➕ Thêm món ăn</div>
        <div class="card-body">
            <form method="post" class="row g-3">
                <div class="col-md-6">
                    <input name="name" class="form-control" placeholder="Tên món" required>
                </div>
                <div class="col-md-4">
                    <input name="price" type="number" class="form-control" placeholder="Giá" required>
                </div>
                <div class="col-md-6">
                    <input name="category" class="form-control" placeholder="Danh mục (VD: Gà rán)">
                </div>
                <div class="col-md-6">
                    <input name="image" class="form-control" placeholder="Link ảnh (VD: images/mon1.jpg)">
                </div>
                <div class="col-md-12">
                    <textarea name="description" class="form-control" rows="2" placeholder="Mô tả món ăn"></textarea>
                </div>
                <div class="col-md-12 text-end">
                    <button class="btn btn-success px-4" type="submit" name="add_food">➕ Thêm</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Danh sách món ăn -->
    <div class="card mb-5">
        <div class="card-header bg-primary text-white">📋 Danh sách món ăn</div>
        <div class="card-body">
            <?php foreach ($foods as $food): ?>
                <form method="post" class="row g-2 align-items-center mb-3">
                    <input type="hidden" name="id" value="<?= $food['id'] ?>">
                    <div class="col-md-3">
                        <input name="name" value="<?= htmlspecialchars($food['name']) ?>" class="form-control" required>
                    </div>
                    <div class="col-md-2">
                        <input name="price" type="number" value="<?= $food['price'] ?>" class="form-control" required>
                    </div>
                    <div class="col-md-2">
                        <input name="category" value="<?= htmlspecialchars($food['category']) ?>" class="form-control">
                    </div>
                    <div class="col-md-2">
                        <input name="image" value="<?= htmlspecialchars($food['image']) ?>" class="form-control">
                    </div>
                    <div class="col-md-3">
                        <input name="description" value="<?= htmlspecialchars($food['description']) ?>" class="form-control">
                    </div>
                    <div class="col-md-2">
                        <button name="update_food" type="submit" class="btn btn-warning w-100">Cập nhật</button>
                    </div>
                    <div class="col-md-2">
                        <button name="delete_food" type="submit" class="btn btn-danger w-100" onclick="return confirm('Bạn có chắc muốn xoá?')">Xoá</button>
                    </div>
                </form>
            <?php endforeach; ?>
        </div>
    </div>

    <!-- Danh sách đặt bàn -->
    <h2 class="text-center mb-4 text-primary"><i class="bi bi-people-fill me-2"></i>Danh sách Đặt Bàn</h2>
    <div class="table-responsive">
        <table class="table table-bordered table-hover align-middle">
            <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th>Họ tên</th>
                    <th>SĐT</th>
                    <th>Số người</th>
                    <th>Ngày giờ</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($reservations as $r): ?>
                    <tr>
                        <td><?= htmlspecialchars($r['id']) ?></td>
                        <td><?= htmlspecialchars($r['name']) ?></td>
                        <td><?= htmlspecialchars($r['phone']) ?></td>
                        <td><?= htmlspecialchars($r['people']) ?></td>
                        <td><?= date('d/m/Y H:i', strtotime($r['datetime'])) ?></td>
                    </tr>
                <?php endforeach; ?>
                <?php if (count($reservations) === 0): ?>
                    <tr>
                        <td colspan="5" class="text-center text-muted">Chưa có lượt đặt bàn nào.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <!-- Nút chuyển trang -->
    <div class="d-grid gap-2 mb-5">
        <a href="index.php" class="btn btn-outline-secondary fw-bold">
            <i class="bi bi-house-door"></i> Quay về trang chủ
        </a>
        <a href="orders.php" class="btn btn-outline-secondary fw-bold">
            <i class="bi bi-clock-history"></i> Lịch sử Mua Hàng
        </a>
    </div>

</div>
</body>
</html>
