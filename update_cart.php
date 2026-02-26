<?php
include 'session_start.php';

$table_id = isset($_GET['table']) ? intval($_GET['table']) : 0;

if (!empty($_SESSION['cart'])) {
  // ปรับจำนวนแบบปุ่ม +/−
  if (isset($_POST['step_up'])){
    $idx = intval($_POST['step_up']);
    $_SESSION['cart'][$idx]['quantity'] = max(1, $_SESSION['cart'][$idx]['quantity'] + 1);
  }
  if (isset($_POST['step_down'])){
    $idx = intval($_POST['step_down']);
    $_SESSION['cart'][$idx]['quantity'] = max(1, $_SESSION['cart'][$idx]['quantity'] - 1);
  }

  // อัปเดตจำนวนจาก input
  if (isset($_POST['qty'])){
    foreach($_POST['qty'] as $i=>$q){
      $_SESSION['cart'][$i]['quantity'] = max(1, intval($q));
    }
  }

  // อัปเดตหมายเหตุ
  if (isset($_POST['note'])){
    foreach($_POST['note'] as $i=>$n){
      $_SESSION['cart'][$i]['note'] = trim($n);
    }
  }

  // ลบ
  if (isset($_POST['remove'])){
    foreach($_POST['remove'] as $i){
      unset($_SESSION['cart'][(int)$i]);
    }
    $_SESSION['cart'] = array_values($_SESSION['cart']);
  }
}

header("Location: cart.php?table=$table_id");
exit;