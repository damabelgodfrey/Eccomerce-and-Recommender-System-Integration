<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/ecommerce/core/init.php';
unset($_SESSION['Userid']);
unset($_SESSION['Username']);
unset($_SESSION['user_email']);

if(isset($_SESSION['discount'])){
  unset($_SESSION['discount']);
}
if(isset($_SESSION['total_item_ordered'])){
  unset($_SESSION['total_item_ordered']);
}
if(isset($_SESSION['maintenance_admin_login'])){
   unset ($_SESSION['maintenance_admin_login']);
 }
  header('location: index');
?>
