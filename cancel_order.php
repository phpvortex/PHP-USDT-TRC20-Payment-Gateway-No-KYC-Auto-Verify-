<?php
include "config.php";
$o=$_GET['o']??'';
mysqli_query($db,"UPDATE orders SET status='expired' WHERE order_code='$o'");
header("Location: expired.php");
exit;
