<?php
include "config.php";

$product = "Website Template";
$price_usdt = 10;

$wallet = mysqli_fetch_assoc(mysqli_query($db,"
  SELECT * FROM wallets ORDER BY RAND() LIMIT 1
"));

$micro = ($price_usdt * 1000000) + rand(1,999);

$code = "ORD".time().rand(100,999);

mysqli_query($db,"
 INSERT INTO orders
 (order_code,product_name,amount_micro,wallet_id,status,created_at)
 VALUES
 ('$code','$product','$micro',{$wallet['id']},'pending',NOW())
");

header("Location: pay.php?o=".$code);
exit;
