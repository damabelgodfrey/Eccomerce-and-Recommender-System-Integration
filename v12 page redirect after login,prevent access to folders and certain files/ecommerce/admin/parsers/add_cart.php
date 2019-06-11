<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/ecommerce/core/init.php';
$product_id = sanitize($_POST['product_id']);
$size = sanitize($_POST['size']);
$available = sanitize($_POST['available']);
$quantity = sanitize($_POST['quantity']);
$request = sanitize($_POST['request']);
$price = sanitize($_POST['price']);
$item = array();
$item[] = array(
  'id'            => $product_id,
  'price'            => $price,
  'size'          => $size,
  'quantity'      => $quantity,
  'request'      => $request,
);

$domain = ($_SERVER['HTTP_HOST'] != 'localhost:81')?'.'.$_SERVER['HTTP_HOST']:false;

updateProductQty($item,$db);
$query = $db->query("SELECT * FROM products WHERE id = '{$product_id}'");
$product = mysqli_fetch_assoc($query);

//check if the cart exists
cart_wishlist_update('cart',$db,$item,$cart_id,$user_name,$json_update,$cart_expire);
 ?>
