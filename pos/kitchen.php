<?php
// kitchen.php
// ใช้ในเครื่อง POS/ครัว เพื่อดูออเดอร์เข้าใหม่และอัปเดตสถานะ
?>
<!DOCTYPE html>
<html lang="th">

<head>
  <meta charset="UTF-8">
  <title>ครัว/พนักงาน - ออเดอร์เข้า</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
  .order-card {
    border-left: 6px solid #0d6efd;
  }

  .order-card.pending {
    border-left-color: #6c757d;
  }

  .order-card.preparing {
    border-left-color: #0d6efd;
  }

  .order-card.serving {
    border-left-color: #ffc107;
  }

  .order-card.completed {
    border-left-color: #198754;
  }
  </style>
</head>

<body class="bg-light">
  <div class="container py-3">
    <div class="d-flex justify-content-between align-items-center">
      <h3>📦 ออเดอร์เข้าครัว</h3>
      <div class="text-muted">รีเฟรชอัตโนมัติ</div>
    </div>
    <hr>
    <div id="orders"></div>
  </div>

  <script>
  async function fetchOrders() {
    const res = await fetch('pos_api_orders.php');
    const data = await res.json();
    const wrap = document.getElementById('orders');
    wrap.innerHTML = '';

    if (!data.length) {
      wrap.innerHTML = '<div class="alert alert-secondary">ตอนนี้ยังไม่มีออเดอร์</div>';
      return;
    }

    for (const o of data) {
      const itemsHTML = o.items.map(it => `
      <li class="list-group-item d-flex justify-content-between align-items-center">
        <div>
          <b>${it.item_name}</b>
          <div class="text-muted small">หมายเหตุ: ${it.note || '-'}</div>
        </div>
        <div>x ${it.quantity} | ${parseFloat(it.price).toFixed(2)} ฿</div>
      </li>
    `).join('');

      const card = document.createElement('div');
      card.className = 'card mb-3 order-card ' + o.status;
      card.innerHTML = `
      <div class="card-header d-flex justify-content-between align-items-center">
        <div>
          <b>ออเดอร์ ${o.order_code}</b>
          <span class="badge bg-secondary ms-2">${o.table_name}</span>
          <span class="badge bg-info text-dark ms-2">${o.status_th}</span>
        </div>
        <small class="text-muted">${o.created_at}</small>
      </div>
      <ul class="list-group list-group-flush">${itemsHTML}</ul>
      <div class="card-body d-flex gap-2 flex-wrap">
        <button class="btn btn-sm btn-outline-primary" onclick="updateStatus('${o.order_code}','preparing')">กำลังทำ</button>
        <button class="btn btn-sm btn-outline-warning" onclick="updateStatus('${o.order_code}','serving')">กำลังไปเสิร์ฟ</button>
        <button class="btn btn-sm btn-success" onclick="updateStatus('${o.order_code}','completed')">เสิร์ฟแล้ว</button>
        <button class="btn btn-sm btn-outline-danger ms-auto" onclick="updateStatus('${o.order_code}','cancelled')">ยกเลิก</button>
      </div>
    `;
      wrap.appendChild(card);
    }
  }

  async function updateStatus(order_code, status) {
    const fd = new FormData();
    fd.append('order_code', order_code);
    fd.append('status', status);
    const res = await fetch('pos_update_status.php', {
      method: 'POST',
      body: fd
    });
    await fetchOrders();
  }

  fetchOrders();
  setInterval(fetchOrders, 5000);
  </script>
</body>

</html>