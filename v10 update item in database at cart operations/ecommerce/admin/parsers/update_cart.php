<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/ecommerce/core/init.php';
$mode = sanitize($_POST['mode']);
$edit_size = sanitize($_POST['edit_size']);
$edit_id = sanitize($_POST['edit_id']);
$edit_quantity = sanitize($_POST['edit_quantity']);
$available = sanitize($_POST['edit_available']);
$cartQ = $db->query("SELECT * FROM cart WHERE id = '{$cart_id}'");
$result = mysqli_fetch_assoc($cartQ);
$items = json_decode($result['items'],true);
$updated_items =array();
$domain = (($_SERVER['HTTP_HOST'] != 'localhost:81')?'.'.$_SERVER['HTTP_HOST']:false);
updateProductQtyupdate($mode,$items,$db,$edit_id,$edit_size,$edit_quantity);
//add and remove item from the cart inteface

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
    if($item['quantity'] > 0){
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
      updateProductQty($item,$db);
      $item['quantity'] = 0;
      $updated_items[] = $item;
  }
}
if(!empty($updated_items)){
  $json_update = json_encode($updated_items);
  $db->query("UPDATE cart SET items = '{$json_update}' WHERE id = '{$cart_id}'");
  $_SESSION['success_flash'] = 'Your shopping cart has been updated';
}

//if user cart is empty delete it from database and unset the CART_COOKIE
//You may choose to keep it to know what user are pairing or selecting.
if(empty($updated_items)){
  $db->query("DELETE FROM cart WHERE id = '{$cart_id}'");
  setcookie(CART_COOKIE,'',1,"/",$domain,false);
}
 ?>
