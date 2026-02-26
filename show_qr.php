<?php
include 'phpqrcode/qrlib.php';
$dir = "qrcodes/";
$total_tables = 1;
?>
<!DOCTYPE html>
<html lang="th">

<head>
  <meta charset="UTF-8">
  <title>QR Code โต๊ะ</title>
  <style>
  body {
    font-family: Tahoma;
    text-align: center;
    background: #f8f9fa;
  }

  .table-qr {
    display: inline-block;
    margin: 15px;
    padding: 15px;
    border: 1px solid #ddd;
    border-radius: 10px;
    background: #fff;
  }

  img {
    width: 200px;
    height: 200px;
  }
  </style>
</head>

<body>
  <h1>QR Code โต๊ะทั้งหมด</h1>
  <?php
for ($i=1;$i<=$total_tables;$i++) {
    $url = "https://petra-satisfactionless-burl.ngrok-free.dev/projectpos/index.php";
    $file = $dir."table_$i.png";
//     if (!file_exists($file)) QRcode::png($url, $file, QR_ECLEVEL_L, 6);
//     echo "<div class='table-qr'><img src='$file'><h3>โต๊ะ $i</h3></div>";
// }
        // ลบเงื่อนไข if ออก บังคับสร้างไฟล์ QRCode ใหม่ทับของเดิมเสมอ
        QRcode::png($url, $file, QR_ECLEVEL_L, 6);

        // แสดงผล
        echo "<div class='table-qr'>
                <img src='$file'>
                <h3>POS $i</h3>
                <p><a href='$url' target='_blank'> $i</a></p>
              </div>";
    }
?>
  <td>

  </td>
</body>

</html>