<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8">
  <title>Liên Hệ - Gà Rán Ngon</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
  <style>
    .contact-header {
      background-color: #dc3545;
      color: white;
      padding: 60px 0;
      text-align: center;
    }
    .contact-header h1 {
      font-weight: bold;
    }
    .contact-info i {
      font-size: 1.5rem;
      color: #dc3545;
      margin-right: 10px;
    }
    .form-control, .btn {
      border-radius: 8px;
    }
    iframe {
      border: 0;
      border-radius: 12px;
      width: 100%;
      height: 350px;
    }
  </style>
</head>
<body>

<!-- Header -->
<section class="contact-header">
  <div class="container">
    <h1><i class="bi bi-envelope-fill me-2"></i>Liên Hệ Chúng Tôi</h1>
    <p>Chúng tôi luôn sẵn sàng lắng nghe bạn!</p>
  </div>
</section>

<!-- Main Content -->
<div class="container my-5">
  <div class="row g-4">
    <!-- Thông tin liên hệ -->
    <div class="col-md-6">
      <h4 class="mb-4">Thông Tin Liên Hệ</h4>
      <div class="contact-info mb-3">
        <i class="bi bi-geo-alt-fill"></i> 123 Đường Gà Rán, Quận 1, TP.HCM
      </div>
      <div class="contact-info mb-3">
        <i class="bi bi-telephone-fill"></i> 0909 123 456
      </div>
      <div class="contact-info mb-3">
        <i class="bi bi-envelope-fill"></i> support@garan-ngon.vn
      </div>
      <div class="contact-info mb-3">
        <i class="bi bi-clock-fill"></i> Giờ mở cửa: 10:00 - 22:00 (Tất cả các ngày)
      </div>

      <!-- Google Maps -->
      <div class="mt-4">
        <iframe 
          src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3919.331556116035!2d106.70042327583176!3d10.785251159048632!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x31752f3cb35cdbb9%3A0x8f86f5f518bd0c0b!2zUGhhbSBOZ3V54buFbiBOZ8O0biBI4bqhbmggQ2hp4buDbiBTw6FjaA!5e0!3m2!1svi!2s!4v1658651192694!5m2!1svi!2s" 
          allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade">
        </iframe>
      </div>
    </div>

    <!-- Biểu mẫu gửi liên hệ -->
    <div class="col-md-6">
      <h4 class="mb-4">Gửi Tin Nhắn</h4>
      <form action="send_contact.php" method="post">
        <div class="mb-3">
          <label for="name" class="form-label">Họ tên</label>
          <input type="text" name="name" class="form-control" placeholder="Nguyễn Văn A" required>
        </div>
        <div class="mb-3">
          <label for="email" class="form-label">Email</label>
          <input type="email" name="email" class="form-control" placeholder="email@example.com" required>
        </div>
        <div class="mb-3">
          <label for="message" class="form-label">Nội dung</label>
          <textarea name="message" rows="5" class="form-control" placeholder="Lời nhắn..." required></textarea>
        </div>
        <button type="submit" class="btn btn-danger w-100 fw-bold"><i class="bi bi-send-fill me-1"></i> Gửi liên hệ</button>
      </form>
    </div>
  </div>
    <div class="row mt-5">
      <div class="col text-center">
        <a href="index.php" class="btn btn-danger btn-lg"><i class="bi bi-house-door-fill me-1"></i> Quay lại Trang Chủ</a>
      </div>
    </div>
</div>

<!-- Footer -->
<footer class="text-center py-4 border-top bg-light">
  <p class="mb-0 text-muted">&copy; 2025 Gà Rán Ngon. All rights reserved.</p>
</footer>

</body>
</html>
