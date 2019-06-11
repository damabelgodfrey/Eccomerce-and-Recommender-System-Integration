<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/ecommerce/core/init.php';
unset($_SESSION['Userid']);
unset($_SESSION['Username']);
header('Location: login')
?>
