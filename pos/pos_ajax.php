<?php
include 'connect.php';
$o=$conn->query("SELECT * FROM orders ORDER BY created_at DESC");
$html="";
while($ord=$o->fetch_assoc()){
  $html.="<div class='card p-3 mb-3'><h4>โต๊ะ {$ord['table_id']} - ออเดอร์ #{$ord['order_id']} ({$ord['status']})</h4><ul>";
  $i=$conn->query("SELECT oi.*,m.item_name FROM order_items oi JOIN menu_items m ON oi.item_id=m.item_id WHERE order_id={$ord['order_id']}");
  while($r=$i->fetch_assoc()){
    $html.="<li>{$r['item_name']} x {$r['quantity']} ({$r['note']})</li>";
  }
  $html.="</ul>
    <form method='post' action='update_status.php'>
      <input type='hidden' name='order_id' value='{$ord['order_id']}'>
      <select name='status' class='form-select d-inline w-auto'>
        <option ".($ord['status']=="pending"?"selected":"").">pending</option>
        <option ".($ord['status']=="cooking"?"selected":"").">cooking</option>
        <option ".($ord['status']=="serving"?"selected":"").">serving</option>
        <option ".($ord['status']=="done"?"selected":"").">done</option>
      </select>
      <button class='btn btn-primary btn-sm'>อัปเดต</button>
    </form></div>";
}
$count=$o->num_rows;
echo json_encode(["html"=>$html,"count"=>$count]);
?>