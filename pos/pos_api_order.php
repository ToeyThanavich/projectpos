<?php
header('Content-Type: application/json; charset=utf-8');
include 'connect.php';

$status_map = [
  'pending'   => 'รอรับออเดอร์',
  'cooking' => 'กำลังทำ',
  'serving'   => 'กำลังไปเสิร์ฟ',
  'completed' => 'เสิร์ฟแล้ว',
  'cancelled' => 'ยกเลิกแล้ว'
];

$sql = "SELECT o.order_id, o.order_code, o.status, o.created_at, t.table_name
        FROM orders o
        JOIN tables t ON o.table_id = t.table_id
        WHERE o.status IN ('pending','preparing','serving')
        ORDER BY o.created_at ASC";
$res = $conn->query($sql);

$out = [];
while($o = $res->fetch_assoc()){
  $oid = (int)$o['order_id'];
  $items = $conn->query("SELECT oi.quantity, oi.price, oi.note, m.item_name 
                         FROM order_items oi 
                         JOIN menu_items m ON oi.item_id=m.item_id
                         WHERE oi.order_id=$oid");
  $arr = [];
  while($it = $items->fetch_assoc()){
    $arr[] = $it;
  }
  $o['items'] = $arr;
  $o['status_th'] = $status_map[$o['status']] ?? $o['status'];
  $out[] = $o;
}

echo json_encode($out, JSON_UNESCAPED_UNICODE);