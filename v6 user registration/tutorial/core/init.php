<?php
$db = mysqli_connect('127.0.0.1','root','','store');


if (mysqli_connect_errno()) {
  echo 'Database Connection falled with the following error:', mysqli_connect_error();
  die();
}
session_start(); //start a session. it put in init class because it is included on all our pages
require_once $_SERVER['DOCUMENT_ROOT'].'/tutorial/config.php';
require_once BASEURL. 'helpers/helpers.php';
require BASEURL.'vendor/autoload.php';
$cart_id = '';
if(isset($_COOKIE[CART_COOKIE])){
  $cart_id = sanitize($_COOKIE[CART_COOKIE]);
}

// get customer data or user data in backend
if(isset($_SESSION['SBUser'])){
  $user_id = $_SESSION['SBUser'];
  $query = $db->query("SELECT * FROM users WHERE id = '$user_id'");
  $query2 = $db->query("SELECT * FROM customer_user WHERE id = '$user_id'");
  $user_data = mysqli_fetch_assoc($query);
  $customer_data = mysqli_fetch_assoc($query2);
  $fn = explode(' ', $user_data['full_name']);
  $fn2 = explode(' ', $customer_data['full_name']);

  $user_data['first'] = $fn[0];
  $customer_data['first'] = $fn2[0];
  //ensure there is no offset variable when there is only first name
  if(count($fn) < 2){
  $user_data['last'] = '';
  }else{$user_data['last'] = $fn[1];}
 }

if(isset($_SESSION['success_flash'])){
  echo '<div class="bg-success"><p class= "text-success text-center">'.$_SESSION['success_flash'].'</p></div>';
  unset($_SESSION['success_flash']); //do not want the above message to show up everytime a page is reloaded or nagavited
}

if(isset($_SESSION['error_flash'])){
  echo '<div class="bg-danger"><p class= "text-danger text-center">'.$_SESSION['error_flash'].'</p></div>';
  unset($_SESSION['error_flash']); //do not want the above message to show up everytime a page is reloaded or nagavited
}
