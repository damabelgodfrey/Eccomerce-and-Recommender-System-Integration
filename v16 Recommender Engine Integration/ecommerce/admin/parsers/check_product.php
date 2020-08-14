<?php
if(isset($_POST['product_id'])){
  require_once $_SERVER['DOCUMENT_ROOT'].'/ecommerce/core/init.php';
  $remain =-1;
  $dmode = sanitize($_POST['dmode']);
  $product_id = sanitize($_POST['product_id']);
  $mysize = sanitize($_POST['size']);
  $quantity = (int)sanitize($_POST['quantity']);
  $errors = array();
  $productQ = $db->query("SELECT * FROM products WHERE id = '{$product_id}'");
  if(mysqli_num_rows($productQ) == 1){
  $product = mysqli_fetch_assoc($productQ);
  $sizes = sizesToArray($product['sizes']); //function in helper file
    foreach($sizes as $size){
        if($size['size'] == $mysize){
          $available = (int)$size['quantity'];
          $remain = $available - $quantity;
        }
    }

    if($remain <0){
      $errors[] ='Quantity or Size choosen is not availabel in stock.';
    }
  }else{
    $errors[] ='product could not be captured';
  }

  if(!empty($errors)){
    echo display_errors($errors);
  }else{
    echo 'success';
  }
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
