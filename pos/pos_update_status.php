<?php
include 'connect.php';

$order_code = isset($_POST['order_code']) ? trim($_POST['order_code']) : '';
$status     = isset($_POST['status']) ? trim($_POST['status']) : '';

$allow = ['pending','cooking','serving','completed','cancelled'];
if (!$order_code || !in_array($status,$allow,true)){
  http_response_code(400); echo 'bad request'; exit;
}

$stmt = $conn->prepare("UPDATE orders SET status=? WHERE order_code=?");
$stmt->bind_param('ss', $status, $order_code);
$stmt->execute();

echo 'ok';