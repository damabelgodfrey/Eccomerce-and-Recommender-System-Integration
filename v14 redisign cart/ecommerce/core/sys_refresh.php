<?php
/*
This script move all expired product from cart to wishlist
*/
require_once $_SERVER['DOCUMENT_ROOT'].'/ecommerce/core/staff-init.php';
$paid = 0;
$current_time = time();
$cartQ = $db->query("SELECT * FROM cart WHERE paid='$paid'");
foreach($cartQ as $cart){
  $cart_hold=  $current_time-$cart['exp_time'];
  if($cart_hold > 36){
      expireReturnProduct($cart['id'],$cart['username'],$db);
  }
}
$db->close();
?>
<script>
setTimeout(function() {
  location.reload();
}, 1000); // 7200000 reload page after every 2 hrs.
</script>
