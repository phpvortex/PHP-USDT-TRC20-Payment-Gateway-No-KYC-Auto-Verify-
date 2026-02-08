<?php
include "config.php";

$o = $_GET['o'] ?? '';
$q = mysqli_query($db,"
 SELECT o.*,w.address
 FROM orders o
 JOIN wallets w ON w.id=o.wallet_id
 WHERE o.order_code='$o'
");
$order = mysqli_fetch_assoc($q);
if(!$order) die("Order not found");

// status check
if($order['status']=='expired'){
 header("Location: expired.php"); exit;
}
if($order['status']=='paid'){
 header("Location: success.php"); exit;
}

$created = strtotime($order['created_at']);
$expire = $created + (59*60);
if(time()>$expire){
 mysqli_query($db,"UPDATE orders SET status='expired' WHERE id={$order['id']}");
 header("Location: expired.php"); exit;
}

$amount = number_format($order['amount_micro']/1000000,6,'.','');
$left = $expire - time();
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>USDT Payment</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<style>
body{
 background:linear-gradient(135deg,#0f172a,#020617);
 color:#fff;
 font-family:tahoma;
}
.card-modern{
 height:320px;
 background:linear-gradient(145deg,#111827,#1f2937);
 border-radius:20px;
 box-shadow:0 15px 35px rgba(0,0,0,.6);
 display:flex;
 align-items:center;
 justify-content:center;
 flex-direction:column;
 text-align:center;
}
.addr{
 background:#000;
 padding:10px;
 border-radius:10px;
 word-break:break-all;
 cursor:pointer;
}
#timer{font-size:2.5rem;color:#facc15;}
</style>
</head>
<body>

<div class="container mt-5">
<div class="row g-4">

<div class="col-md-4">
<div class="card-modern">
<h4>USDT TRC20 Payment</h4>
<p><?= $order['product_name'] ?></p>
</div>
</div>

<div class="col-md-4">
<div class="card-modern">
<h5>Amount</h5>
<div class="display-6 text-success"><?= $amount ?> USDT</div>
</div>
</div>

<div class="col-md-4">
<div class="card-modern">
<h5>Scan QR</h5>
<img src="assets/qr.php?addr=<?= $order['address'] ?>" width="180">
</div>
</div>

<div class="col-md-4">
<div class="card-modern" onclick="copyAddr()">
<h5>Wallet Address</h5>
<div class="addr"><?= $order['address'] ?></div>
<small>Click to copy</small>
</div>
</div>

<div class="col-md-4">
<div class="card-modern">
<h5>Time Left</h5>
<div id="timer"></div>
<button class="btn btn-outline-danger mt-3" onclick="cancelPay()">Cancel Payment</button>
</div>
</div>

<div class="col-md-4">
<div class="card-modern">
<p>Send exact amount</p>
<p>Only TRC20 network</p>
</div>
</div>

</div>
</div>

<script>
let t = <?= $left ?>;
function copyAddr(){
 navigator.clipboard.writeText("<?= $order['address'] ?>");
 alert("Address copied");
}
function tick(){
 let m=Math.floor(t/60),s=t%60;
 timer.innerText=`${m.toString().padStart(2,'0')}:${s.toString().padStart(2,'0')}`;
 if(t--<=0) location.reload();
}
setInterval(tick,1000); tick();

function cancelPay(){
 if(confirm("Cancel this payment?")){
  location.href="cancel_order.php?o=<?= $order['order_code'] ?>";
 }
}
</script>
</body>
</html>
