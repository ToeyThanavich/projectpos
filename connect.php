<?php
  $host = "localhost";
  $user = "root";
  $pass = "";
  $dbname = "cafe_pos";

  $conn = mysqli_connect($host,$user,$pass,$dbname) or die ('ไม่สมารถเชื่อมต่อกับ database ได้');
  $conn->query("SET NAMES UTF8");

?>