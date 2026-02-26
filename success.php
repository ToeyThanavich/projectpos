<?php
include 'connect.php';
$order_id = intval($_GET['order']);
$q = $conn->query("SELECT * FROM orders WHERE order_id=$order_id");
$o = $q->fetch_assoc();
?>
<!DOCTYPE html>
<html lang="th">

<head>
  <meta charset="UTF-8">
  <title>สำเร็จ</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="container py-5 text-center">
  <h1>✅ สั่งอาหารเรียบร้อยแล้ว</h1>
  <p>เลขที่ออเดอร์: <b><?php echo $o['order_code']; ?></b></p>
  <a href="menu_detail.php?table=<?php echo $o['table_id']; ?>" class="btn btn-primary">🔙 กลับไปที่เมนู</a>
</body>

</html>