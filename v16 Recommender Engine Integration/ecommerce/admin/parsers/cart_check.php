<?php
if(isset($_POST['cart_id'])){
 require_once $_SERVER['DOCUMENT_ROOT'].'/ecommerce/core/init.php';
<<<<<<< HEAD
 $errors = array();
  $mode = (($_POST['mode'] != '')?sanitize($_POST['mode']):'');
  $cart_id = (int)(($_POST['cart_id'] != '')?sanitize($_POST['cart_id']):'');
  if($mode == 'wish' || $mode == 'wishdelete'){
    $wishlistRepObj= new WishListRepoController();
    $itemQ = $wishlistRepObj->selectWishlist($cart_id); //->query("SELECT * FROM wishlist WHERE id ='{$cart_id}'");
  }else{
   $cartRepObj= new cartRepoController();
  $itemQ = $cartRepObj->selectCart($cart_id);
  }
  $return = count($itemQ);
=======
$paid = 0;
$errors = array();
  $mode = (($_POST['mode'] != '')?sanitize($_POST['mode']):'');
  $cart_id = (($_POST['cart_id'] != '')?sanitize($_POST['cart_id']):'');
  if($mode == 'wish' || $mode == 'wishdelete'){
    $itemQ = $db->query("SELECT * FROM wishlist WHERE id ='{$cart_id}'");
  }else{
    $itemQ = $db->query("SELECT * FROM cart WHERE id ='{$cart_id}'AND paid = '{$paid}'");
  }
  $return = mysqli_num_rows($itemQ);
>>>>>>> 00946282fd0ced214a37681e144e38779b687dd4
  if($return !=1){
    $errors[] ='Item has expired or has been removed. Please refresh page and check your saved list';
  }
  if(!empty($errors)){
    echo display_errors($errors);
  }else{
    echo 'success';
  }
<<<<<<< HEAD
=======
  $db->close();
>>>>>>> 00946282fd0ced214a37681e144e38779b687dd4
}else{
  if(isset($_SESSION['rdrurl'])){
    $link= $_SESSION['rdrurl'];
  }else{
    $link = '/ecommerce/index';
  }
  $_SESSION['error_flash'] = 'Unrecognised action!';
  header('Location:'.$link);
}
?>
