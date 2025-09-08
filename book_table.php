<?php
require 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $name = $_POST['name'] ?? '';
  $phone = $_POST['phone'] ?? '';
  $people = $_POST['people'] ?? 1;
  $datetime = $_POST['datetime'] ?? '';

  $stmt = $pdo->prepare("INSERT INTO reservations (name, phone, people, datetime) VALUES (?, ?, ?, ?)");
  $stmt->execute([$name, $phone, $people, $datetime]);

  header("Location: index.php?success=1");
  exit;
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Đặt Bàn - Gà Rán Ngon</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
  <style>
    body {
      background-color: #fefefe;
    }
    .booking-wrapper {
      background-color: #fff;
      border-radius: 12px;
      overflow: hidden;
      box-shadow: 0 5px 20px rgba(0,0,0,0.1);
    }
    .booking-img {
      object-fit: cover;
      height: 100%;
      width: 100%;
    }
    .form-label {
      font-weight: 600;
    }
    .form-control {
      border-radius: 8px;
    }
    .btn-danger {
      border-radius: 8px;
    }
    .section-title {
      font-size: 2rem;
      font-weight: bold;
    }
    @media (max-width: 768px) {
      .booking-img {
        height: 200px;
      }
    }
  </style>
</head>
<body>

<!-- Container chính -->
<div class="container py-5">
  <div class="text-center mb-5">
    <h2 class="section-title text-danger"><i class="bi bi-calendar-check-fill me-2"></i>Đặt bàn ngay</h2>
    <p class="text-muted">Đặt chỗ trước để không phải chờ đợi khi đến thưởng thức Gà Rán Ngon!</p>
  </div>

  <div class="row booking-wrapper">
    <!-- Ảnh bên trái -->
    <div class="col-md-6 d-none d-md-block">
      <img src="bantaicuahang.jpg" alt="Đặt bàn" class="booking-img">
    </div>

    <!-- Form đặt bàn -->
    <div class="col-md-6 p-4">
      <form action="book_table.php" method="post">
        <div class="mb-3">
          <label class="form-label">Họ và tên</label>
          <input type="text" name="name" class="form-control" placeholder="Nguyễn Văn A" required>
        </div>
        <div class="mb-3">
          <label class="form-label">Số điện thoại</label>
          <input type="tel" name="phone" class="form-control" placeholder="0912345678" required>
        </div>
        <div class="mb-3">
          <label class="form-label">Số người</label>
          <input type="number" name="people" class="form-control" min="1" max="20" value="2" required>
        </div>
        <div class="mb-4">
          <label class="form-label">Ngày & Giờ</label>
          <input type="datetime-local" name="datetime" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-danger w-100 fw-bold"><i class="bi bi-check-circle-fill me-1"></i> Đặt bàn</button>
      </form>
    </div>
  </div>
</div>
<div class="d-grid gap-2">
  <a href="index.php" class="btn btn-outline-secondary fw-bold">
    <i class="bi bi-arrow-left-circle me-1"></i> Quay lại Trang chủ
  </a>
  <a href="reservations_list.php" class="btn btn-info fw-bold mt-3">
  <i class="bi bi-list-ul me-1"></i> Xem danh sách đặt bàn
</a>

</div>


<!-- Footer -->
<footer class="text-center py-4 mt-5 border-top bg-light">
  <p class="mb-0 text-muted">&copy; 2025 Gà Rán Ngon. All rights reserved.</p>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
