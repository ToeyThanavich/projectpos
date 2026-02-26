<?php
include 'connect.php';
$orders = $conn->query("SELECT * FROM orders ORDER BY order_time DESC");
?>
<!DOCTYPE html>
<html lang="th">

<head>
  <meta charset="UTF-8">
  <title>POS Dashboard</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="container py-4">
  <h1>📋 ออเดอร์ทั้งหมด</h1>
  <table class="table table-bordered">
    <tr>
      <th>โต๊ะ</th>
      <th>รหัสออเดอร์</th>
      <th>สถานะ</th>
      <th>จัดการ</th>
    </tr>
    <?php while($o=$orders->fetch_assoc()): ?>
    <tr>
      <td><?= $o['table_id'] ?></td>
      <td><?= $o['order_code'] ?></td>
      <td><?= $o['status'] ?></td>
      <td>
        <a href="update_status.php?order_code=<?= $o['order_code'] ?>&status=cooking"
          class="btn btn-warning btn-sm">👨‍🍳 กำลังทำ</a>
        <a href="update_status.php?order_code=<?= $o['order_code'] ?>&status=serving" class="btn btn-success btn-sm">✅
          เสิร์ฟแล้ว</a>
        <a href="update_status.php?order_code=<?= $o['order_code'] ?>&status=cancelled" class="btn btn-danger btn-sm">❌
          ยกเลิก</a>
      </td>
    </tr>
    <?php endwhile; ?>
  </table>
</body>

</html>