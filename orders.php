<?php
session_start();
require 'db.php';

// Giả sử bạn đã đăng nhập và có $_SESSION['user_id']
$user_id = $_SESSION['user_id'] ?? null;
if (!$user_id) {
    header("Location: login.php");
    exit;
}

// Truy vấn các đơn hàng của người dùng hiện tại
$stmt = $pdo->prepare("SELECT * FROM orders WHERE user_id = ? ORDER BY created_at DESC");
$stmt->execute([$user_id]);
$orders = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>🧾 Đơn hàng đã mua</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h2 class="mb-4">🧾 Đơn hàng của bạn</h2>

    <?php if (empty($orders)): ?>
        <div class="alert alert-info">Bạn chưa mua đơn hàng nào.</div>
    <?php else: ?>
        <?php foreach ($orders as $order): ?>
            <div class="card mb-4">
                <div class="card-header bg-dark text-light">
                    Đơn hàng #<?= $order['id'] ?> – ngày <?= date('d/m/Y H:i', strtotime($order['created_at'])) ?>
                </div>
                <div class="card-body">
                    <table class="table table-bordered table-hover">
                        <thead>
                            <tr>
                                <th>Món ăn</th>
                                <th>Số lượng</th>
                                <th>Giá</th>
                                <th>Tạm tính</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php
                        $stmtItems = $pdo->prepare("
                            SELECT oi.*, f.name 
                            FROM order_items oi 
                            JOIN foods f ON oi.food_id = f.id 
                            WHERE oi.order_id = ?
                        ");
                        $stmtItems->execute([$order['id']]);
                        $items = $stmtItems->fetchAll();
                        foreach ($items as $item):
                        ?>
                            <tr>
                                <td><?= htmlspecialchars($item['name']) ?></td>
                                <td><?= $item['quantity'] ?></td>
                                <td><?= number_format($item['price'], 0) ?>đ</td>
                                <td><?= number_format($item['price'] * $item['quantity'], 0) ?>đ</td>
                            </tr>
                        <?php endforeach; ?>
                        </tbody>
                    </table>
                    <<div class="text-end fw-bold fs-5 text-danger">
Tổng cộng: <?= number_format($order['total'], 0) ?>đ
</div>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>
    <div class="text-end">
    <form action="delete_order.php" method="POST" onsubmit="return confirm('Bạn có chắc muốn xóa đơn hàng này?');">
        <input type="hidden" name="order_id" value="<?= $order['id'] ?>">
        <button type="submit" class="btn btn-sm btn-danger">🗑️ Xóa đơn hàng</button>
    </form>
</div>
    <a href="index.php" class="btn btn-outline-secondary">⬅️ Quay lại trang chủ</a>
    
</div>
</body>
</html>
