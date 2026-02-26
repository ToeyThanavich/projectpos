<?php
include 'connect.php';

$order_code = $_GET['order_code'] ?? '';
if (!$order_code) {
    echo "ไม่พบออเดอร์";
    exit;
}

$q = $conn->prepare("SELECT status FROM orders WHERE order_code=?");
$q->bind_param("s", $order_code);
$q->execute();
$res = $q->get_result()->fetch_assoc();

if ($res) {
    echo "สถานะปัจจุบัน: <b>" . htmlspecialchars($res['status']) . "</b>";
} else {
    echo "ไม่พบออเดอร์";
}