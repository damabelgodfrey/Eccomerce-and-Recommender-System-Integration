<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/ecommerce/core/init.php';
unset($_SESSION['Userid']);
unset($_SESSION['Username']);
<<<<<<< HEAD
unset($_SESSION['user_email']);
=======
>>>>>>> 00946282fd0ced214a37681e144e38779b687dd4

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
