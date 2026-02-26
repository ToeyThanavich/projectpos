<?php
session_start();
$table_id = isset($_GET['table']) ? (int)$_GET['table'] : 0;
$i = isset($_GET['i']) ? (int)$_GET['i'] : -1;

if (isset($_SESSION['cart'][$i])) {
    unset($_SESSION['cart'][$i]);
    // reindex array ป้องกัน key ข้าม
    $_SESSION['cart'] = array_values($_SESSION['cart']);
}

header("Location: cart.php?table=$table_id");
exit;