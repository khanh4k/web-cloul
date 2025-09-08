<?php
session_start();
require 'db.php';

// Lấy danh sách món ăn
$stmt = $pdo->query("SELECT * FROM foods");
$foods = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>🍽 Thực đơn món ăn</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
</head>
<body class="bg-light">
<div class="container mt-5">
    <h2 class="mb-4 text-center text-primary">🍽 Thực đơn</h2>

    <div class="row">
        <?php if (empty($foods)): ?>
            <div class="col-12 text-center text-muted">Không có món ăn nào.</div>
        <?php else: ?>
            <?php foreach ($foods as $food): ?>
                <div class="col-md-4 mb-4">
                    <div class="card h-100 shadow-sm border-0">
                        <?php if ($food['image']): ?>
                            <img src="<?= htmlspecialchars($food['image']) ?>" class="card-img-top" alt="<?= htmlspecialchars($food['name']) ?>" style="height: 200px; object-fit: cover;">
                        <?php endif; ?>
                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title text-danger"><?= htmlspecialchars($food['name']) ?></h5>
                            <p class="card-text text-muted small"><?= htmlspecialchars($food['description']) ?></p>
                            <p class="fw-bold text-success"><?= number_format($food['price'], 0) ?>k</p>
                            <form method="post" action="cart.php" class="d-flex align-items-center mt-auto">
                                <input type="hidden" name="food_id" value="<?= $food['id'] ?>">
                                <input type="number" name="quantity" value="1" min="1" class="form-control me-2 w-25">
                                <button type="submit" class="btn btn-sm btn-outline-primary">🛒 Thêm</button>
                            </form>
                            <a href="food_detail.php?id=<?= $food['id'] ?>" class="btn btn-link text-decoration-none mt-2">📖 Chi tiết</a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>

    <div class="mt-4 text-center">
        <a href="cart.php" class="btn btn-success">🛍 Xem giỏ hàng</a>
        <a href="index.php" class="btn btn-outline-secondary">⬅️ Trang chủ</a>
    </div>
</div>
</body>
</html>
