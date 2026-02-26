<?php
session_start();
include 'connect.php';
include 'functions.php';

//  ดึงจาก session ไม่ใช่ GET
$table_id = $_SESSION['table_id'] ?? 0;

// ถ้าไม่มีค่า ให้ redirect กลับไปเลือกโต๊ะใหม่
if ($table_id <= 0) {
    header("Location: index.php");
    exit;
}
// ดึง order ล่าสุดของโต๊ะนี้
$res = $conn->query("SELECT order_id, order_code FROM orders WHERE table_id=$table_id ORDER BY order_id DESC LIMIT 1");
$order_id = 0;
$order_code = '';
if ($row = $res->fetch_assoc()) {
    $order_id = $row['order_id'];
    $order_code = $row['order_code']; //  เก็บ order_code ไว้ใช้
}



// ดึงหมวดหมู่
$cats = $conn->query("SELECT * FROM categories ORDER BY sort_order, category_name");
$cat_list = [];
while($c = $cats->fetch_assoc()){ $cat_list[] = $c; }
?>
<!DOCTYPE html>
<html lang="th">

<head>
  <meta charset="UTF-8">
  <title>เมนูคาเฟ่</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
  .sticky-cart {
    position: fixed;
    right: 16px;
    bottom: 16px;
    z-index: 999;
  }

  .menu-card img {
    object-fit: cover;
    height: 160px;
  }
  </style>
</head>

<body class="bg-light">
  <div class="container py-3">
    <div class="d-flex justify-content-between align-items-center">
      <h3 class="mb-0">📋 เมนูสั่งออนไลน์ (โต๊ะ <?php echo $table_id; ?>)</h3>
      <a class="btn btn-outline-primary" href="cart.php?table=<?php echo $table_id; ?>">🛒 ตะกร้า
        <?php if(!empty($_SESSION['cart'])) echo '('.array_sum(array_column($_SESSION['cart'],'quantity')).')'; ?>
      </a>
    </div>
    <hr>

    <!-- Tabs หมวดหมู่ -->
    <ul class="nav nav-pills mb-3" id="pills-tab">
      <?php foreach($cat_list as $i=>$cat): ?>
      <li class="nav-item" role="presentation">
        <button class="nav-link <?php echo $i==0?'active':''; ?>" id="tab<?php echo $cat['category_id']; ?>"
          data-bs-toggle="pill" data-bs-target="#cat<?php echo $cat['category_id']; ?>" type="button">
          <?php echo htmlspecialchars($cat['category_name']); ?>
        </button>
      </li>
      <?php endforeach; ?>
    </ul>

    <div class="tab-content">
      <?php foreach($cat_list as $i=>$cat): 
      $cid = (int)$cat['category_id'];
      $stmt = $conn->prepare("SELECT * FROM menu_items WHERE active=1 AND category_id=? ORDER BY item_name");
      $stmt->bind_param('i',$cid);
      $stmt->execute();
      $items = $stmt->get_result();
    ?>
      <div class="tab-pane fade <?php echo $i==0?'show active':''; ?>" id="cat<?php echo $cid; ?>">
        <div class="row g-3">
          <?php while($m = $items->fetch_assoc()): ?>
          <div class="col-12 col-md-6 col-lg-4">
            <div class="card h-100 menu-card">
              <?php if(!empty($m['image'])): ?>
              <img src="uploads/<?php echo htmlspecialchars($m['image']); ?>" class="card-img-top" alt="">
              <?php else: ?>
              <img src="https://via.placeholder.com/600x400?text=<?php echo urlencode($m['item_name']); ?>"
                class="card-img-top" alt="">
              <?php endif; ?>
              <div class="card-body d-flex flex-column">
                <h5 class="card-title"><?php echo htmlspecialchars($m['item_name']); ?>
                  <?php if($m['size']) echo '('.htmlspecialchars($m['size']).')'; ?></h5>
                <p class="text-muted small mb-2"><?php echo nl2br(htmlspecialchars($m['description'])); ?></p>
                <div class="mt-auto d-flex justify-content-between align-items-center">
                  <strong><?php echo money($m['price']); ?> บาท</strong>
                  <button class="btn btn-success btn-sm" data-bs-toggle="modal"
                    data-bs-target="#addModal<?php echo $m['item_id']; ?>">เพิ่ม</button>
                </div>
              </div>
            </div>
          </div>

          <!--  เพิ่มลงตะกร้า -->
          <div class="modal fade" id="addModal<?php echo $m['item_id']; ?>" tabindex="-1">
            <div class="modal-dialog">
              <form class="modal-content" method="post" action="add_to_cart.php">
                <div class="modal-header">
                  <h5 class="modal-title">เพิ่ม: <?php echo htmlspecialchars($m['item_name']); ?></h5>
                  <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                  <input type="hidden" name="id" value="<?php echo $m['item_id']; ?>">
                  <input type="hidden" name="table" value="<?php echo $table_id; ?>">
                  <div class="mb-3">
                    <label class="form-label">จำนวน</label>
                    <input type="number" name="qty" class="form-control" value="1" min="1">
                  </div>
                  <div class="mb-3">
                    <label class="form-label">หมายเหตุ</label>
                    <input type="text" name="note" class="form-control" placeholder="เช่น หวานน้อย, เพิ่มช็อต">
                  </div>
                </div>
                <div class="modal-footer">
                  <button class="btn btn-success" type="submit">เพิ่มลงตะกร้า</button>
                </div>
              </form>
            </div>
          </div>
          <?php endwhile; ?>
        </div>
      </div>
      <?php endforeach; ?>
    </div>
  </div>
  <!-- ปุ่มตะกร้า -->
  <a class="btn btn-primary rounded-pill shadow sticky-cart" href="cart.php?table=<?php echo $table_id; ?>">
    🛒 ตะกร้า
  </a>

  <!-- ปุ่มเช็คสถานะ -->
  <?php if (!empty($order_code)): ?>
  <a class="btn btn-warning rounded-pill shadow sticky-status" href="track.php?order_code=<?php echo $order_code; ?>">
    📦 เช็คสถานะ
  </a>
  <?php endif; ?>





  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>



<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>