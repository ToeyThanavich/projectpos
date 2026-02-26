<?php
session_start();
include 'connect.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $table_id = intval($_POST['table_id']);

    // ตรวจสอบว่ามีโต๊ะนี้จริงหรือไม่
    $check = $conn->query("SELECT * FROM tables WHERE table_id = $table_id");

    if ($check && $check->num_rows > 0) {
        // เก็บค่าโต๊ะไว้ใน session
        $_SESSION['table_id'] = $table_id;
        header("Location: menu_detail.php"); // ไปหน้าสั่งเมนู
        exit;
    } else {
        $error = "❌ โต๊ะนี้ไม่มีอยู่ในระบบ กรุณากรอกใหม่";
    }
}
?>

<!DOCTYPE html>
<html lang="th">

<head>
  <meta charset="UTF-8">
  <title>เลือกโต๊ะ</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="container py-4">

  <h1>🪑 กรอกหมายเลขโต๊ะ</h1>

  <?php if (!empty($error)): ?>
  <div class="alert alert-danger"><?= $error ?></div>
  <?php endif; ?>

  <form method="post" class="mt-3">
    <div class="mb-3">
      <label class="form-label">หมายเลขโต๊ะ</label>
      <input type="number" name="table_id" class="form-control" required>
    </div>
    <button type="submit" class="btn btn-primary">ยืนยัน</button>
  </form>

</body>

</html>