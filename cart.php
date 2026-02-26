<?php
session_start();
$table_id = isset($_GET['table']) ? (int)$_GET['table'] : 0;
$cart = $_SESSION['cart'] ?? [];
$total = 0.0;
?>
<!DOCTYPE html>
<html lang="th">

<head>
  <meta charset="UTF-8">
  <title>ตะกร้า</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="container py-4">
  <h1>🛒 ตะกร้า โต๊ะ <?php echo $table_id; ?></h1>

  <table class="table table-bordered">
    <tr>
      <th>เมนู</th>
      <th>จำนวน</th>
      <th>ราคา</th>
      <th>หมายเหตุ</th>
      <th>จัดการ</th>
    </tr>

    <?php if (empty($cart)) : ?>
    <tr>
      <td colspan="5" class="text-center">ยังไม่มีสินค้าในตะกร้า</td>
    </tr>
    <?php else: ?>
    <?php foreach ($cart as $i => $c):
        $qty   = isset($c['qty']) ? (int)$c['qty'] : (int)($c['quantity'] ?? 1);
        $price = (float)$c['price'];
        $sum   = $price * $qty;
        $total += $sum;
      ?>
    <tr>
      <td><?= htmlspecialchars($c['name']) ?></td>
      <td><?= $qty ?></td>
      <td><?= number_format($sum, 2) ?></td>
      <td><?= htmlspecialchars($c['note']) ?></td>
      <td>
        <a class="btn btn-danger btn-sm" href="remove_item.php?i=<?= $i ?>&table=<?= $table_id ?>"
          onclick="return confirm('ลบเมนูนี้ออกจากตะกร้า?')">❌ ลบ</a>
      </td>
    </tr>
    <?php endforeach; ?>
    <tr>
      <td colspan="2"><b>รวม</b></td>
      <td colspan="3"><b><?= number_format($total, 2) ?> บาท</b></td>
    </tr>
    <?php endif; ?>
  </table>

  <form method="post" action="checkout.php?table=<?php echo $table_id; ?>">
    <button class="btn btn-success w-100" <?= empty($cart)?'disabled':''; ?>>✅ ยืนยันการสั่ง</button>
  </form>

  <div class="mt-3">
    <a class="btn btn-secondary w-100" href="menu_detail.php?table=<?php echo $table_id; ?>">⬅️ กลับไปเลือกเมนู</a>
  </div>
</body>

</html>