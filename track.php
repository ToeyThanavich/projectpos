<?php
session_start();
include 'connect.php';
include 'functions.php';

$order_code = $_GET['order_code'] ?? '';
if (!$order_code) {
    header("Location: menu_detail.php");
    exit;
}

$q = $conn->prepare("SELECT * FROM orders WHERE order_code=?");
$q->bind_param("s", $order_code);
$q->execute();
$order = $q->get_result()->fetch_assoc();

if (!$order) {
    die("ไม่พบออเดอร์");
}
?>
<!DOCTYPE html>
<html lang="th">

<head>
  <meta charset="UTF-8">
  <title>ติดตามออเดอร์</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="container py-4">
  <h1>📌 ติดตามออเดอร์</h1>
  <p>รหัสออเดอร์: <b><?php echo $order_code; ?></b></p>
  <p>สถานะ: <span class="badge bg-info"><?php echo htmlspecialchars($order['status']); ?></span></p>
  <a href="menu_detail.php?table=<?php echo $o['table_id']; ?>" class="btn btn-primary">🔙 กลับไปที่เมนู</a>
  
</body>

</html>