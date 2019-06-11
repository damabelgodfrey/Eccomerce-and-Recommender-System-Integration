<?php
$db = mysqli_connect('127.0.0.1','root','','store');


if (mysqli_connect_errno()) {
  echo 'Database Connection falled with the following error:', mysqli_connect_error();
  die();
}
session_start(); //start a session. it put in init class because it is included on all our pages
require_once $_SERVER['DOCUMENT_ROOT'].'/ecommerce/config.php';
require_once BASEURL. 'helpers/helpers.php';
require BASEURL.'vendor/autoload.php';
$staff_cart_id = '';

// get customer data or user data in backend
if(isset($_SESSION['staff_username'])){

  if((time()- $_SESSION['last_staff_login_timestamp']) > 7190) // 1hr * 60 before page reload set at two hrs log user our first if log in
    {
      //expireReturnProduct($_SESSION['cartid'],$_SESSION['Username'],$db);
      header("location:logout");
    }else{
      $_SESSION['last_staff_login_timestamp'] = time();
      $staff_id = sanitize(  $_SESSION['staff_id']);
      $staff_username = sanitize($_SESSION['staff_username']);
    //  if(isset($_COOKIE[CART_COOKIE])){
      //  $cart_id = sanitize($_COOKIE[CART_COOKIE]);
    //  }
    if(isset($_SESSION['staff_cart_id'])){
     $staff_cart_id = sanitize($_SESSION['staff_cart_id']);
    }
      $querystaff = $db->query("SELECT * FROM users WHERE username = '$staff_username'");
      $return = mysqli_num_rows($querystaff);
      if($return == 1){
        $staff_data = mysqli_fetch_assoc($querystaff);
        $staff_email = $staff_data['email'];
        $A_fn = explode(' ', $staff_data['full_name']);
        $staff_data['first'] = $A_fn[0];
      //ensure there is no offset variable when there is only first name
        if(count($A_fn) < 2){
          $staff_data['last'] = '';
        }else{
          $staff_data['last'] = $A_fn[1];
        }
     }
 }
}
if(isset($_SESSION['success_flash'])){
  echo '<div class="bg-success"><p class= "text-success text-center">'.$_SESSION['success_flash'].'</p></div>';
  unset($_SESSION['success_flash']); //do not want the above message to show up everytime a page is reloaded or nagavited
}

if(isset($_SESSION['error_flash'])){
  echo '<div class="bg-danger"><p class= "text-danger text-center">'.$_SESSION['error_flash'].'</p></div>';
  unset($_SESSION['error_flash']);
}

if(isset($_SESSION['warning_flash'])){
  echo '<div class="bg-warning"><p class= "text-warning text-center">'.$_SESSION['warning_flash'].'</p></div>';
  unset($_SESSION['error_flash']);
}
