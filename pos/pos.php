<!DOCTYPE html>
<html lang="th">

<head>
  <meta charset="UTF-8">
  <title>POS ครัว</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>

<body class="container py-4">
  <h1>👩‍🍳 POS ครัว</h1>
  <div id="orders"></div>
  <audio id="ding" src="https://actions.google.com/sounds/v1/alarms/beep_short.ogg"></audio>
  <script>
  let lastCount = 0;

  function loadPOS() {
    $.get("pos_ajax.php", function(data) {
      $("#orders").html(data.html);
      if (data.count > lastCount) {
        document.getElementById("ding").play();
      }
      lastCount = data.count;
    }, "json");
  }
  setInterval(loadPOS, 3000);
  loadPOS();
  </script>
</body>

</html>