<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/ecommerce/core/init.php';
unset($_SESSION['Userid']);
unset($_SESSION['Username']);
if(isset($_SESSION['total_item_ordered'])){
  unset($_SESSION['total_item_ordered']);
}
header('Location: login')
?>
