<?php
session_start();
require 'db.php';

if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

// Thêm món vào giỏ
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['food_id'];
    $qty = $_POST['quantity'];
    $_SESSION['cart'][$id] = ($_SESSION['cart'][$id] ?? 0) + $qty;
    header("Location: cart.php");
    exit;
}

$total = 0;
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>🛒 Giỏ hàng</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="container mt-5 text-light">
    <h2 class="mb-4 text-warning">🛒 Giỏ hàng của bạn</h2>

    <?php if (empty($_SESSION['cart'])): ?>
        <div class="alert alert-info">Chưa có món nào trong giỏ hàng.</div>
        <a href="menu.php" class="btn btn-primary">🍔 Xem thực đơn</a>
    <?php else: ?>
        <table class="table table-dark table-hover table-bordered align-middle">
            <thead class="table-light text-dark">
                <tr>
                    <th>Món ăn</th>
                    <th>Số lượng</th>
                    <th>Đơn giá</th>
                    <th>Tạm tính</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($_SESSION['cart'] as $id => $qty): 
                    $food = $pdo->query("SELECT * FROM foods WHERE id = $id")->fetch();
                    if (!$food) continue;
                    $subtotal = $food['price'] * $qty;
                    $total += $subtotal;
                ?>
                    <tr>
                        <td><?= htmlspecialchars($food['name']) ?></td>
                        <td><?= $qty ?></td>
                        <td><?= number_format($food['price'], 0) ?>k</td>
                        <td class="text-success fw-bold"><?= number_format($subtotal, 0) ?>k</td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <div class="text-end fs-5 mb-4">
            <strong class="text-warning">Tổng cộng: <?= number_format($total, 0) ?>k</strong>
        </div>

        <div class="d-flex justify-content-between">
            <a href="menu.php" class="btn btn-outline-light">← Tiếp tục mua sắm</a>
            <a href="checkout.php" class="btn btn-success btn-lg">💳 Thanh toán</a>
        </div>
    <?php endif; ?>
</div>
<div class="d-grid gap-2">
  <a href="index.php" class="btn btn-outline-secondary fw-bold">
    <i class="bi bi-arrow-left-circle me-1"></i> Quay lại Trang chủ
  </a>
  <div class="d-grid gap-2">
  <a href="orders.php" class="btn btn-outline-secondary fw-bold">
    <i class="bi bi-arrow-left-circle me-1"></i> Lịch Sử Mua Hàng
  </a>
</div>
</div>
</body>
</html>
