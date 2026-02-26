<?php
include 'connect.php';
include 'functions.php';

$order_code = isset($_GET['order']) ? trim($_GET['order']) : '';
if (!$order_code){ die('ไม่พบรหัสออเดอร์'); }

$stmt = $conn->prepare("SELECT o.*, t.table_name FROM orders o JOIN tables t ON o.table_id=t.table_id WHERE o.order_code=?");
$stmt->bind_param('s',$order_code);
$stmt->execute();
$order = $stmt->get_result()->fetch_assoc();
if (!$order){ die('ไม่พบออเดอร์นี้'); }

$items = $conn->prepare("SELECT oi.*, m.item_name FROM order_items oi JOIN menu_items m ON oi.item_id=m.item_id WHERE oi.order_id=?");
$oid = (int)$order['order_id'];
$items->bind_param('i',$oid);
$items->execute();
$rs = $items->get_result();

$status_map = [
  'pending'   => 'รอรับออเดอร์',
  'preparing' => 'กำลังทำ',
  'serving'   => 'กำลังไปเสิร์ฟ',
  'completed' => 'เสิร์ฟแล้ว',
  'cancelled' => 'ยกเลิกแล้ว'
];
?>
<!DOCTYPE html>
<html lang="th">

<head>
  <meta charset="UTF-8">
  <title>สถานะออเดอร์</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <script>
  // รีเฟรชข้อมูลทุก 7 วินาที
  setInterval(() => {
    location.reload();
  }, 7000);
  </script>
</head>

<body class="bg-light">
  <div class="container py-4">
    <h3>สถานะออเดอร์: <?php echo htmlspecialchars($order_code); ?>
      (<?php echo htmlspecialchars($order['table_name']); ?>)</h3>
    <p>สถานะปัจจุบัน:
      <span class="badge bg-info text-dark">
        <?php echo $status_map[$order['status']] ?? $order['status']; ?>
      </span>
    </p>

    <div class="card">
      <div class="card-header">รายการอาหาร</div>
      <div class="card-body">
        <ul class="list-group">
          <?php while($row=$rs->fetch_assoc()): ?>
          <li class="list-group-item d-flex justify-content-between align-items-center">
            <div>
              <b><?php echo htmlspecialchars($row['item_name']); ?></b>
              <div class="text-muted small">หมายเหตุ: <?php echo htmlspecialchars($row['note']); ?></div>
            </div>
            <div>x <?php echo (int)$row['quantity']; ?> | <?php echo money($row['price']); ?> ฿</div>
          </li>
          <?php endwhile; ?>
        </ul>
      </div>
    </div>

    <div class="mt-3">
      <a class="btn btn-outline-secondary"
        href="index.php?table=<?php echo (int)$order['table_id']; ?>">กลับไปสั่งเพิ่ม</a>
    </div>
  </div>
</body>

</html>