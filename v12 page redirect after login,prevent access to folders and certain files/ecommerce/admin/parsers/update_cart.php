<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/ecommerce/core/init.php';
$mode = sanitize($_POST['mode']);
$edit_size = sanitize($_POST['edit_size']);
$edit_id = sanitize($_POST['edit_id']);
$edit_quantity = sanitize($_POST['edit_quantity']);
$available = sanitize($_POST['edit_available']);
$paid = 0;
  $_SESSION['success_flash'] = $mode. ' was added to your cart.';
if($mode == 'wish'){
  $cartQ = $db->query("SELECT * FROM wishlist WHERE username = '{$user_name}'");
}else{
  $cartQ = $db->query("SELECT * FROM cart WHERE username = '{$user_name}' AND paid = '{$paid}'");
}
$result = mysqli_fetch_assoc($cartQ);
$items = json_decode($result['items'],true);
$updated_items =array();
//$domain = (($_SERVER['HTTP_HOST'] != 'localhost:81')?'.'.$_SERVER['HTTP_HOST']:false);
if($mode != 'wish'){
updateProductQtyupdate($mode,$items,$db,$edit_id,$edit_size,$edit_quantity);
}

if($mode == 'removeone'){
  foreach($items as $item){
    if($item['id'] == $edit_id && $item['size'] == $edit_size){

        $item['quantity'] = (int)$item['quantity'] - 1;
    }
    if($item['quantity'] > 0){
      $updated_items[] = $item;
    //  updateProductQtyupdate($mode,$items,$db);
    }

  }
}

if($mode == 'delete'){
  foreach($items as $item){
    if($item['id'] == $edit_id && $item['size'] == $edit_size){
      //updateProductQtyupdate($mode,$items,$db);
      $item['quantity'] = 0;
    }
    if($item['size'] != $edit_size){
      $updated_items[] = $item;
   }
  }
}

if($mode == 'wish'){
  foreach($items as $item){
    if($item['id'] == $edit_id && $item['size'] == $edit_size){
      //updateProductQtyupdate($mode,$items,$db);
      //$item['quantity'] = 0;
    }
    if($item['size'] != $edit_size && $item['id'] != $edit_id){
      $updated_items[] = $item;
   }
  }
}

if($mode == 'addone'){
  foreach($items as $item){
    if($item['id'] == $edit_id && $item['size'] == $edit_size){
      if($available > 0){
        $item['quantity'] = $item['quantity'] + 1;
      }

    }
      $updated_items[] = $item;
      //updateProductQtyupdate($mode,$items,$db);
  }
}

if($mode == 'expire'){
  foreach($items as $item){
      //updateProductQtyupdate($mode,$items,$db);
      //updateProductQty($item,$db);
      $item['quantity'] = 0;
      $updated_items[] = $item;
  }
}

if(!empty($updated_items)){
  $json_update = json_encode($updated_items);
  if($mode == 'wish'){
   $db->query("UPDATE wishlist SET items = '{$json_update}' WHERE username = '{$user_name}'");
   $_SESSION['success_flash'] = 'Your wish list has been updated';
 }else{
   $db->query("UPDATE cart SET items = '{$json_update}' WHERE username = '{$user_name}' AND paid = '{$paid}'");
   $_SESSION['success_flash'] = 'Your shopping cart has been updated';
 }
}

//if user cart is empty delete it from database and unset the CART_COOKIE
//You may choose to keep it to know what user are pairing or selecting.
if(empty($updated_items)){
  if($mode == 'wish'){
  $db->query("DELETE FROM wishlist WHERE username = '{$user_name}'");
}else{
  $db->query("DELETE FROM cart WHERE username = '{$user_name}' AND paid = '{$paid}'");
//setcookie(CART_COOKIE,'',1,"/",$domain,false);
}
}
 ?>
