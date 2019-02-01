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
$cart_id = '';

// get customer data or user data in backend
if(isset($_SESSION['Username'])){

  if((time()- $_SESSION['last_login_timestamp']) > 3600) // 1hr * 60
    {
      header("location:logout.php");
    }else{
      $_SESSION['last_login_timestamp'] = time();
      $user_id = $_SESSION['Userid'];
      $user_name = $_SESSION['Username'];
    //  if(isset($_COOKIE[CART_COOKIE])){
      //  $cart_id = sanitize($_COOKIE[CART_COOKIE]);
    //  }
      $cart_id = $_SESSION['Username'];
      $query1 = $db->query("SELECT * FROM customer_user WHERE username = '$user_name'");
      $query2 = $db->query("SELECT * FROM users WHERE username = '$user_name'");
    if(!is_null($query1)){
       $query = $query1;
    }else{
      $query = $query2;
    }
      $user_data = mysqli_fetch_assoc($query);
      $email = $user_data['email'];
      $fn = explode(' ', $user_data['full_name']);
      $user_data['first'] = $fn[0];
      //ensure there is no offset variable when there is only first name
        if(count($fn) < 2){
          $user_data['last'] = '';
        }else{
          $user_data['last'] = $fn[1];
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
