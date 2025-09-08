<?php
require 'db.php';
$id = $_GET['id'] ?? null;
if (!$id) {
    header("Location: index.php");
    exit;
}
$stmt = $pdo->prepare("SELECT * FROM foods WHERE id = ?");
$stmt->execute([$id]);
$food = $stmt->fetch();
if (!$food) {
    echo "Không tìm thấy món ăn.";
    exit;
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8">
  <title>Chi tiết món ăn</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container my-5">
  <a href="index.php" class="btn btn-outline-secondary mb-4">⬅ Quay lại</a>
  <div class="row">
    <div class="col-md-6">
      <img src="<?= $food['image'] ?>" class="img-fluid rounded" alt="Ảnh món ăn">
    </div>
    <div class="col-md-6">
      <h2><?= htmlspecialchars($food['name']) ?></h2>
      <p class="text-muted"><?= htmlspecialchars($food['description']) ?></p>
      <p class="text-success fw-bold h5"><?= number_format($food['price'], 0) ?>k</p>
      <p><strong>Loại:</strong> <?= htmlspecialchars($food['category']) ?: 'Không có' ?></p>
      <form method="post" action="cart.php" class="d-flex align-items-center mt-3">
        <input type="hidden" name="food_id" value="<?= $food['id'] ?>">
        <input type="number" name="quantity" value="1" min="1" class="form-control me-2 w-25">
        <button type="submit" class="btn btn-success">🛒 Thêm vào giỏ</button>
      </form>
    </div>
  </div>
</div>
</body>
</html>
