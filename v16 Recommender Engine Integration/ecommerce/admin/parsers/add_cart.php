<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/ecommerce/core/init.php';
$dmode = sanitize($_POST['dmode']);
$product_id = sanitize($_POST['product_id']);
$size = sanitize($_POST['size']);
$available = sanitize($_POST['available']);
$quantity = sanitize($_POST['quantity']);
$discount = sanitize($_POST['discount']);

$request = sanitize($_POST['request']);
$price = sanitize($_POST['price']);
$item = array();
$item[] = array(
  'id'            => $product_id,
  'price'            => $price,
  'size'          => $size,
  'quantity'      => $quantity,
  'request'      => $request,
  'discount'      => $discount

);

$domain = ($_SERVER['HTTP_HOST'] != 'localhost:81')?'.'.$_SERVER['HTTP_HOST']:false;

if ($dmode == 'cart') {
  updateProductQty($item,$db);
  $_SESSION['total_item_ordered'] =   $_SESSION['total_item_ordered'] + $quantity;
}
//$query = $db->query("SELECT * FROM products WHERE id = '{$product_id}'");
//$product = mysqli_fetch_assoc($query);
//function in helpers file to add product to cart.
$json_update = ''; //not applicable
cart_wishlist_update($dmode,$db,$item,$cart_id,$user_name,$json_update,$cart_expire,$available);
 ?>
