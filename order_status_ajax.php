<?php
include 'connect.php';
$table_id=intval($_GET['table']);
$o=$conn->query("SELECT * FROM orders WHERE table_id=$table_id ORDER BY created_at DESC");
while($ord=$o->fetch_assoc()){
  echo "<h4>ออเดอร์ #{$ord['order_id']} ({$ord['status']})</h4><ul>";
  $i=$conn->query("SELECT oi.*,m.item_name FROM order_items oi JOIN menu_items m ON oi.item_id=m.item_id WHERE order_id={$ord['order_id']}");
  while($r=$i->fetch_assoc()){
    echo "<li>{$r['item_name']} x {$r['quantity']} ({$r['note']})</li>";
  }
  echo "</ul>";
}
?>