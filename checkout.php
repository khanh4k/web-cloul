<?php
session_start();
require 'db.php';

if (!isset($_SESSION['user_id'])) {
    echo "Vui lòng <a href='login.php'>đăng nhập</a> để thanh toán.";
    exit;
}

$cart = $_SESSION['cart'] ?? [];
if (empty($cart)) {
    echo "Giỏ hàng của bạn đang trống.";
    exit;
}

$total = 0;
$items = [];

// Chuẩn bị dữ liệu từ giỏ hàng
foreach ($cart as $id => $qty) {
    $stmt = $pdo->prepare("SELECT * FROM foods WHERE id = ?");
    $stmt->execute([$id]);
    $food = $stmt->fetch();
    if ($food) {
        $subtotal = $food['price'] * $qty;
        $total += $subtotal;
        $items[] = [
            'id' => $food['id'],
            'name' => $food['name'],
            'price' => $food['price'],
            'quantity' => $qty,
            'subtotal' => $subtotal
        ];
    }
}

// Lưu đơn hàng
$stmt = $pdo->prepare("INSERT INTO orders (user_id, total) VALUES (?, ?)");
$stmt->execute([$_SESSION['user_id'], $total]);
$order_id = $pdo->lastInsertId();

// Lưu từng món vào order_items
foreach ($items as $item) {
    $stmt = $pdo->prepare("INSERT INTO order_items (order_id, food_id, quantity, price) VALUES (?, ?, ?, ?)");
    $stmt->execute([$order_id, $item['id'], $item['quantity'], $item['price']]);
}

// Xóa giỏ hàng sau khi đặt
unset($_SESSION['cart']);
?>

<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8">
  <title>Đơn hàng đã đặt</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container mt-5">
  <h2 class="text-success mb-4">🎉 Đặt hàng thành công!</h2>
  
  <div class="card shadow">
    <div class="card-header bg-success text-white">Chi tiết đơn hàng của bạn</div>
    <ul class="list-group list-group-flush">
      <?php foreach ($items as $item): ?>
        <li class="list-group-item d-flex justify-content-between">
          <?= htmlspecialchars($item['name']) ?> x <?= $item['quantity'] ?>
          <span class="text-success"><?= number_format($item['subtotal'], 0) ?>k</span>
        </li>
      <?php endforeach; ?>
      <li class="list-group-item d-flex justify-content-between fw-bold">
        Tổng cộng: 
        <span class="text-danger"><?= number_format($total, 0) ?>k</span>
      </li>
    </ul>
  </div>

  <div class="mt-4 d-flex justify-content-between">
    <a href="index.php" class="btn btn-outline-primary">🏠 Về Trang chủ</a>
    <a href="menu.php" class="btn btn-outline-success">🍽 Tiếp tục đặt món</a>
  </div>
</div>
</body>
</html>
