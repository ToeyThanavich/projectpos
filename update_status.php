<?php
include 'connect.php';

$order_code = $_GET['order_code'] ?? '';
$status = $_GET['status'] ?? '';

if ($order_code && $status) {
    $stmt = $conn->prepare("UPDATE orders SET status = ? WHERE order_code = ?");
    $stmt->bind_param("ss", $status, $order_code);
    $stmt->execute();
    $stmt->close();
}

header("Location: pos_dashboard.php");
exit;