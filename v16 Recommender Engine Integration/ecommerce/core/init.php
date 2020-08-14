<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/ecommerce/core/DB.php';
session_start(); //start a session. it put in init class because it is included on all our pages
//error_reporting(E_ALL ^ E_WARNING);
error_reporting(E_ALL | E_WARNING | E_NOTICE);
ini_set('display_errors', TRUE);
require_once $_SERVER['DOCUMENT_ROOT'].'/ecommerce/config.php';
require_once BASEURL. 'helpers/helpers.php';
require BASEURL.'vendor/autoload.php';
date_default_timezone_set(TIMEZONE);
$cart_id = '';
// get customer data or user data in backend
if(isset($_SESSION['Username'])){
  if((time()- $_SESSION['last_login_timestamp']) > 7190) // 1hr * 60 before page reload set at two hrs log user our first if log in
    {
      //expireReturnProduct($_SESSION['cartid'],$_SESSION['Username'],$db);
      header("location:logout");
    }else{
      $_SESSION['last_login_timestamp'] = time();
      $user_id = sanitize($_SESSION['Userid']);
      $user_name = sanitize($_SESSION['Username']);
    if(isset($_SESSION['cartid'])){
     $cart_id = sanitize($_SESSION['cartid']);
    }
      $query = $db->query("SELECT * FROM customer_user WHERE username = '$user_name'");
      $return = mysqli_num_rows($query);
      if($return == 1){
      $user_data = mysqli_fetch_assoc($query);
      $email = $user_data['email'];
    $_SESSION['user_email']=  $user_data['email'];
      $fn = explode(' ', $user_data['full_name']);
      $user_data['first'] = $fn[0];
        if(count($fn) < 2){
          $user_data['last'] = '';
        }else{
          $user_data['last'] = $fn[1];
        }
     }
   }
}
$sQ = $db->query("SELECT * FROM settings");
$globalsettings = mysqli_fetch_assoc($sQ);
$appearanceQ = $db->query("SELECT * FROM appearance");
$appearance = mysqli_fetch_assoc($appearanceQ);
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
  unset($_SESSION['warning_flash']);
}
