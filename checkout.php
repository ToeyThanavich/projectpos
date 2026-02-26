<?php
session_start();
include 'connect.php';

$table_id = intval($_GET['table']);
$cart = $_SESSION['cart'] ?? [];

if (empty($cart)) {
    die("❌ ไม่มีสินค้าในตะกร้า");
}

// สร้างรหัสออเดอร์ไม่ซ้ำ
$order_code = "ORD" . date("YmdHis") . rand(100,999);

// บันทึกออเดอร์หลัก
$sql = "INSERT INTO orders (table_id, order_code, status, created_at) 
        VALUES ($table_id, '$order_code', 'pending', NOW())";
$conn->query($sql);
$order_id = $conn->insert_id;

// บันทึกสินค้าในตะกร้า
foreach ($cart as $c) {
    $item_id = $c['id'];
    $qty = $c['qty'];
    $price = $c['price'];
    $note = $conn->real_escape_string($c['note']);
    $conn->query("INSERT INTO order_items (order_id, item_id, quantity, price, note) 
                  VALUES ($order_id, $item_id, $qty, $price, '$note')");
}

// ล้างตะกร้า
unset($_SESSION['cart']);

// redirect ไปหน้าสำเร็จ
header("Location: success.php?order=$order_id");
exit;
?>