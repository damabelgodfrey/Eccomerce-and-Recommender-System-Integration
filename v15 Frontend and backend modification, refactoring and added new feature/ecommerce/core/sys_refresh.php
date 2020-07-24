<?php
/*
This script move all expired product from cart to wishlist
*/
require_once $_SERVER['DOCUMENT_ROOT'].'/ecommerce/core/staff-init.php';
$paid = 0;
$current_time = time();
if(isset($_POST['returncart']))
{
  $cartQ = $db->query("SELECT * FROM cart WHERE paid='$paid'");
  $return = mysqli_num_rows($cartQ);
    if($return > 0){
      foreach($cartQ as $cart){
        $cart_hold=  $current_time-$cart['exp_time'];
        if($cart_hold > 36){
            expireReturnProduct($cart['id'],$cart['username'],$db);
        }
      }
      echo "successful";
    }
  $db->close();
}
?>
<hr>
<form action="refresh_page" method="post">
  <div class="col-xs-6 pull-center">
    <input type="hidden" name="returncart" value="">
    <button type="submit" onclick="return activityconfirm()" class=" form-control btn btn btn-md btn-warning">Return Expired Cart to Saved Item</button>
  </div>
</form>
<script>
setTimeout(function() {
  //location.reload();
}, 10000); // 7200000 reload page after every 2 hrs.

function activityconfirm(){
  var action=confirm("Are you sure you want to return all expired cart item to saved list?");
    if (action==true){
    //alert ("success")
    }
  return action;
}
</script>
