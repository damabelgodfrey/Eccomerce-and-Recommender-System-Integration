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

//check if the cart cookie apc_exists
if($cart_id !=''){
  $cartQ = $db->query("SELECT * FROM cart WHERE id= '{$cart_id}'");
  $cart = mysqli_fetch_assoc($cartQ);
  $previous_items = json_decode($cart['items'],true); //makes it an associated array not an object
  $item_match = 0;
  $new_items = array();
  //$_SESSION['success_flash'] = $product['title']. ' in loop.';
  foreach ($previous_items as $pitem){

    if($item[0]['id'] == $pitem['id'] && $item[0]['size'] == $pitem['size']){
      $pitem['quantity'] =$pitem['quantity'] + $item[0]['quantity'];
      if($pitem['quantity'] > $available){
        $pitem['quantity'] = $available;

      }
      $item_match = 1;
    }
    $new_items[] = $pitem;
  }
  if($item_match != 1){
    $new_items = array_merge($item,$previous_items);
  }
  $items_json = json_encode($new_items);
  $cart_expire = date("Y-m-d H:i:s",strtotime("+30 days"));
  $db->query("UPDATE cart SET items = '{$items_json}', expire_date = '{$cart_expire}' WHERE id = '{$cart_id}'");
  setcookie(CART_COOKIE,'',1,"/",$domain,false);
  setcookie(CART_COOKIE,$cart_id,CART_COOKIE_EXPIRE,'/',$domain,false);
}else{
  //add the cart to database and set cookie
  $items_json = json_encode($item);
  $cart_expire = date("Y-m-d H:i:s",strtotime("+30 days"));
  $db->query("INSERT INTO cart (items,expire_date) VALUES ('{$items_json}','{$cart_expire}')");
  $cart_id = $db->insert_id; //return the last inserted item in database
  setcookie(CART_COOKIE,$cart_id,CART_COOKIE_EXPIRE,'/',$domain,false); //false set security off on local host
  //setcookie(CART_COOKIE, $cart_id, CART_COOKIE_EXPIRE, '/', null);
  $_SESSION['success_flash'] = $product['title']. ' was added to your cart.';
 }

 ?>
