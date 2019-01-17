<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/tutorial/core/init.php';
$name = sanitize($_POST['full_name']);
$email = sanitize($_POST['email']);
$street = sanitize($_POST['street']);
$street2 = sanitize($_POST['street2']);
$city = sanitize($_POST['city']);
$state = sanitize($_POST['state']);
$zip_code = sanitize($_POST['zip_code']);
$country = sanitize($_POST['country']);
$errors = array();
$required = array(
  'full_name'  => 'Full Name',
  'street'     => 'Street Address',
  'city'       => 'city',
  'state'      => 'state',
  //'zip_code'   => 'Zip Code',
  'country'    => 'Country',
);

//check if required filled is filled
foreach($required as $f => $d){
  if(empty($_POST[$f]) || $_POST[$f] ==''){
    $errors[] = $d.' is required';
  }
}

if(!filter_var($email,FILTER_VALIDATE_EMAIL)){
  $errors[] = 'Please enter a valid email!';
}

if(!empty($errors)){
  echo display_errors($errors);
}else{
  echo 'passed';
}

 ?>
