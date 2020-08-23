<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/ecommerce/core/init.php';
if($_POST['mode']){
  $mode = sanitize($_POST['mode']);
  $edit_size = sanitize($_POST['edit_size']);
  $edit_id = sanitize($_POST['edit_id']);
  $edit_quantity = sanitize($_POST['edit_quantity']);
  $available = sanitize($_POST['edit_available']);
  $item_found = 0;
  if($mode == 'wish' || $mode == 'wishdelete'){
    $cartQ = $db->query("SELECT * FROM wishlist WHERE userID = '{$user_id}'");
  }else if($mode == 'wishdelete'){
    $cartQ = $db->query("SELECT * FROM wishlist WHERE userID = '{$user_id}'");
  }else{
    $cartQ = $db->query("SELECT * FROM cart WHERE userID = '{$user_id}'");
  }
  $return = mysqli_num_rows($cartQ);
    if($return > 0){
      $result = mysqli_fetch_assoc($cartQ);
      $items = json_decode($result['items'],true);
      $updated_items =array();
      //$domain = (($_SERVER['HTTP_HOST'] != 'localhost:81')?'.'.$_SERVER['HTTP_HOST']:false);

      if($mode == 'removeone'){
        updateProductQtyupdate($mode,$items,$db,$edit_id,$edit_size,$edit_quantity);
        foreach($items as $item){
          if($item['id'] == $edit_id && $item['size'] == $edit_size){
              $item['quantity'] = (int)$item['quantity'] - 1;
          }
          if($item['quantity'] > 0){
            $updated_items[] = $item;
          //  updateProductQtyupdate($mode,$items,$db);
        }else{
          $_SESSION['total_item_ordered'] =   $_SESSION['total_item_ordered'] -1;
        }

        }
      }

      if($mode == 'delete'){
        updateProductQtyupdate($mode,$items,$db,$edit_id,$edit_size,$edit_quantity);
        foreach($items as $item){
          if($item['id'] == $edit_id && $item['size'] == $edit_size){
            $item['quantity'] = 0;
            $_SESSION['total_item_ordered'] =   $_SESSION['total_item_ordered'] -$edit_quantity;
          }else{
            $updated_items[] = $item;
          }
         }
        }
      if($mode == 'wishdelete'){
        foreach($items as $item){
          if($item['size'] == $edit_size && (int)$item['id'] == (int)$edit_id){
            $item['quantity'] = 0;
          }else{
            $updated_items[] = $item;
          }
         }
        }

      if($mode == 'wish'){
        foreach($items as $item){
          if($item['id'] == $edit_id && $item['size'] == $edit_size){
            //updateProductQtyupdate($mode,$items,$db);
            //$item['quantity'] = 0;
          }else{
            $updated_items[] = $item;
          }

        }
      }

      if($mode == 'addone'){
        updateProductQtyupdate($mode,$items,$db,$edit_id,$edit_size,$edit_quantity);
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
        updateProductQtyupdate($mode,$items,$db,$edit_id,$edit_size,$edit_quantity);
        foreach($items as $item){
            //updateProductQtyupdate($mode,$items,$db);
            //updateProductQty($item,$db);
            $item['quantity'] = 0;
            $updated_items[] = $item;
        }
      }

      if(!empty($updated_items)){
        $newUpItem = json_encode($updated_items);
        if($mode == 'wish' || $mode == 'wishdelete'){
         $db->query("UPDATE wishlist SET items = '{$newUpItem}' WHERE userID = '{$user_id}'");
         $_SESSION['success_flash'] = 'Your wish list has been updated';
       }else{
         $cart_expire = date("Y-m-d H:i:s",strtotime("+30 days"));
         $exp_time = time();
        // $db->query("UPDATE cart SET items = '{$newUpItem}', expire_date = '{$cart_expire}', exp_time = '{$exp_time}'
                    // WHERE userID = '{$user_id}'");
          $repoObject = new CartRepoController();
          $repoObject->updateCart($newUpItem,$cart_expire,$exp_time,$user_id);
         $_SESSION['success_flash'] = 'Your shopping cart has been updated';
       }
      }

      //if user cart is empty delete it from database and unset the CART_COOKIE
      //You may choose to keep it to know what user are pairing or selecting.
      if(empty($updated_items)){
        if($mode == 'wish' || $mode == 'wishdelete'){
         $db->query("DELETE FROM wishlist WHERE userID = '{$user_id}'");
        }else{
         $db->query("DELETE FROM cart WHERE userID = '{$user_id}'");
         $_SESSION['total_item_ordered'] = 0;
      //setcookie(CART_COOKIE,'',1,"/",$domain,false);
       }
      }
    }else{

    }
  }else{
    echo "Item not found";
  }
 ?>
